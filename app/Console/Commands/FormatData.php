<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FormatData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'atoms:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up data after import';

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
        // Lowercase facility_ids
        DB::table('addresses')
            ->update(['facility_id' => DB::raw("lower(facility_id)")]);
        DB::table('facilities')
            ->update(['facility_id' => DB::raw("lower(facility_id)")]);
        DB::table('city_pairs')
            ->update([
                'ORIGIN_AIRPORT_ABBREV' => DB::raw("lower(ORIGIN_AIRPORT_ABBREV)"),
                'DESTINATION_AIRPORT_ABBREV' => DB::raw("lower(DESTINATION_AIRPORT_ABBREV)")
            ]);

        // Leading zeros for zip code
        DB::table('addresses')
            ->update(['zip' => DB::raw("lpad(zip, 5, 0)")]);
        DB::table('perdiems')
            ->update(['zip' => DB::raw("lpad(zip, 5, 0)")]);
    }
}
