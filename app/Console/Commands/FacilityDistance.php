<?php

namespace App\Console\Commands;

use App\Models\Facility;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/**
 * Find distances between facilities
 * https://developers.google.com/maps/documentation/distance-matrix/start#maps_http_distancematrix_start-txt
 *
 * Class FacilityDistance
 * @package App\Console\Commands
 */
class FacilityDistance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'atoms:distance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find distances between facilities';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private $uri = 'https://maps.googleapis.com/maps/api/distancematrix/json';
    private $api_key = 'AIzaSyBDgxkJkF3_OdM19Ve86TwbIeZ7XFsX5Gc';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Retrieve all facilities with siblings
        $facilities = Facility::where('sibling_status', 1)
            ->with(['address', 'siblings.sibling.address'])
//            ->limit(1)
            ->get();

        // Loop through each facility to find out distance
        foreach ($facilities as $facility) {
            // Get sibling addresses into url format
            $siblings = $facility->siblings;
            $destinations = $siblings->pluck('sibling.address.formatted_address')
                ->map(function ($a) {
                    return urlencode($a);
                })
                ->join('|');

            // No siblings
            if ($facility->siblings->count() === 1 && !$facility->siblings[0]->sibling_id) {
                Log::info($facility->facility_id . ' has no siblings.');

                // Update the facility
                $facility->sibling_status = 2;
                $facility->save();

                continue;
            }

            // No address
            if (!$facility->address) {
                Log::info($facility->facility_id . ' has no address.');

                // Update the facility
                $facility->sibling_status = 2;
                $facility->save();

                continue;
            }

            // Fetch the distance matrix
            $c = new Client(['base_uri' => "{$this->uri}"]);
            $r = $c->request('GET', '', [
                'query' => [
                    'origins' => $facility->address->formatted_address,
                    'destinations' => $destinations,
                    'units' => 'imperial',
                    'key' => $this->api_key,
                ]
            ]);
            $result = json_decode($r->getBody());

            // Make sure request is valid
            if (!isset($result->rows[0])) {
                Log::info($facility->facility_id . ' - DEST: ' . $destinations . ' /n/r :: Request has no rows.');
                continue;
            }
            $data = collect($result->rows[0]->elements);//$result['rows'][0]->elements;

            // Update sibling records
            foreach ($siblings as $idx => $sibling) {
                // Handle errors
                if (!isset($data[$idx]->distance) || !isset($data[$idx]->duration)) {
                    Log::info($facility->facility_id . '- SIBLING: ' . $sibling->id . ' :: No distance/duration.');
                    continue;
                }

                // Update the sibling
                $sibling->actual_distance = $data[$idx]->distance->value;
                $sibling->travel_time = $data[$idx]->duration->value;
                $sibling->save();
            }

            // Update sibling status
            $facility->sibling_status = 2; // Has distances
            $facility->save();
        }
    }
}
