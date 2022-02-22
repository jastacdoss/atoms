<?php

namespace App\Console\Commands;

use App\Models\Facility;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CalculateTravelMethods extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'atoms:calc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate cost of travel method based on facility training site.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Clearing cache...');
        Cache::forget('facilities');

        $this->newLine(2);
        $this->info('Fetch facilities...');
        Cache::rememberForever('facilities', function () {
            // Get all facilities
            $facilities = Facility::get();


            $this->withProgressBar($facilities, fn($f) => $f->whos_travelling() );

            $this->newLine(2);
            $this->info('Done!');

            return $facilities;
        });
    }
}
