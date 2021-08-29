<?php

namespace App\Console\Commands;

use App\Models\Facility;
use App\Models\Sibling;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Interact with zipcodeapi.com to find all zips within a radius
 * https://www.zipcodeapi.com/API
 *
 * Class FacilitiesInRange
 * @package App\Console\Commands
 */
class FacilitiesInRange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'atoms:range {--demo}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find facilities within radius of xx miles';

    /**
     * Distance to retrieve facilities within
     * @var string $radius
     */
    protected $radius; // In Miles

    protected $api_url = 'https://www.zipcodeapi.com/rest';
    protected $api_file = 'radius.json';
    protected $api_demo_key = 'DemoOnly00GSber6CujmDEpwRTX9XLOXTLA8DJmP4WZ3JkqO5Yzb0XrCecwol78Z';
    protected $api_key;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // Get API Key
        $this->api_key = env('ZIPCODE_API_KEY');

        // Get distance
        $this->radius = config('atoms.DRIVEABLE_DISTANCE') * 2;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Fetch facilities without siblings');

        // Fetch the facilities
        $facilities = Facility::where('sibling_status', FALSE)
            ->with('address')
            ->limit($this->option('demo') ? 20 : 10)
            ->get();

        // Loop through each facility and make API call for siblings
        foreach ($facilities as $facility) {
            // Message for facility
            $this->info('Finding siblings for ' . $facility->facility_name);

            // Make sure facility has an address
            if (!isset($facility->address)) {
                $facility->sibling_status = 1; // Has Radius
                $facility->save();
                continue;
            }

            // Make the call
            $key = $this->option('demo') ? $this->api_demo_key : $this->api_key;
            $c = new Client(['base_uri' => "{$this->api_url}/{$key}/{$this->api_file}/"]);
            $r = $c->request('GET', "{$facility->address->zip}/{$this->radius}/mile");
            $zips = collect(json_decode($r->getBody())->zip_codes);

            // Find all siblings by zip code
            $siblings = Facility::whereHas('address', function ($q) use ($zips) {
                    $q->whereIn('zip', $zips->pluck('zip_code'));
                })
                ->with('address')
                ->where('id', '!=', $facility->id)
                ->get();

            // See if any siblings found
            if ($siblings->count()) {
                // Loop through siblings and store them
                $childs = new Collection();
                foreach($siblings as $sibling) {
                    // Get distance to sibling
                    $distance = $zips->firstWhere('zip_code', $sibling->address->zip);

                    // Save the sibling
                    $s = new Sibling();
                    $s->facility_id = $facility->id;
                    $s->sibling_id = $sibling->id;
                    $s->zip_distance = $distance->distance ?? 0;
                    $childs->push($s);
                }

                // Attach siblings to the parent
                $facility->siblings()->saveMany($childs);
            } else {
                // Facility has no siblings, prevent them from running again
                $sibling = new Sibling();
                $sibling->fill(['facility_id' => $facility->id]);
                $facility->siblings()->save($sibling);
            }
            // Update sibling status
            $facility->sibling_status = 1; // Has Radius
            $facility->save();
        }
    }
}
