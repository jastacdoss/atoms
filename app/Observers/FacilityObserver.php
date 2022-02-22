<?php

namespace App\Observers;

use App\Models\Facility;
use Carbon\Carbon;

class FacilityObserver
{

    public function saving(Facility $facility)
    {
        $this->updateDates($facility);
    }

    public function updateDates(Facility $facility)
    {
        // Format the date
        $golive = Carbon::create($facility->go_live_date);

        // Update the timelines
        $facility->training_dead_date = $golive->clone()->subWeeks(2);
        $facility->training_start_date = $golive->clone()->subDays(45);
        $facility->poc_training_dead_date = $golive->clone()->subDays(60);
        $facility->notification_dead_date = $golive->clone()->subMonths(6);
    }
}
