<?php

namespace App\Console\Commands;

use App\Models\Facility;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Libraries\DistanceMatrixAPI;

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

    protected $distance;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // Set up the API
        $this->distance = new DistanceMatrixAPI();
    }

    private $uri = 'https://maps.googleapis.com/maps/api/distancematrix/json';
    private $api_key;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // GET API Key
        $this->api_key = env('GOOGLE_API_KEY');

        // Retrieve all facilities with siblings
        $facilities = Facility::where('sibling_status', 1)
            ->with(['address', 'siblings.sibling.address'])
//            ->limit(1)
            ->get();

        // Loop through each facility to find out distance
        foreach ($facilities as $facility) {
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

            // Get sibling addresses into url format
            $destinations = $facility->siblings->pluck('sibling.address.formatted_address');

            // Fetch the distance matrix
            if (!$this->distance->fetch($facility->address->formatted_address, $destinations)) {
                Log::info($facility->facility_id . ' - DEST: ' . $destinations . ' /n/r :: Request has no rows.');
                continue;
            }
            $data = $this->distance->distances();

            // Update sibling records
            foreach ($facility->siblings as $idx => $sibling) {
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
