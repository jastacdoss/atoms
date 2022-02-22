<?php
namespace App\Traits;


use App\Libraries\TravelMethod;
use Illuminate\Support\Collection;

trait FacilityTrainingTrait {
    public function whos_travelling()
    {
        // Set up training collection
        $travellers = new Collection();

        if (!$this->team) {
            $this->travellers = null;
            return $this;
        }

        // See if trainers are on-site or trainees are travelling
        if ($this->facility_id === $this->training_facility) {
            /** Trainers travelling to facility */
            // Get trainers
            $trainers = $this->team->members;

            // Create new travel method object
            $d = new TravelMethod();

            // Loop through each trainer
            foreach($trainers as $trainer) {
                // Calculate costs
                if ($this->facility_id === $trainer->facility->facility_id) {
                    $travel = $lodging = $meals = 0;
                } else {
                    $travel = $d->to($this)->from($trainer->facility)->calculate();
                    $lodging = $this->lodging($travel, $this->perdiem) * (config('atoms.TRAINING_DAYS') - 1);
                    $meals = $this->meals($travel, $this->perdiem);
                }

                $travellers->push([
                    'who' => $trainer->name,
                    'role' => 'trainer',
                    'how_many' => 1,
                    'from' => $trainer->facility->facility_id,
                    'to' => $this->facility_id,
                    'travel' => $travel,
                    'lodging' => $lodging,
                    'meals' => $meals,
                    'cost' => ($travel['cost'] ?? 0) + $lodging + $meals,
                ]);
            }
        } else {
            /** Trainees are travelling to another location */
            $d = new TravelMethod();

            // Calculate costs
            if ($this->facility_id === $this->training->facility_id) {
                $travel = $lodging = $meals = 0;
            } else {
                $travel = $d->to($this->training)->from($this)->calculate();
                $lodging = $this->lodging($travel, $this->training->perdiem) * (config('atoms.TRAINING_DAYS') - 1);
                $meals = $this->meals($travel, $this->training->perdiem);
            }

            $travellers->push([
                'who' => 'POCs',
                'role' => 'trainees',
                'how_many' => $this->areas * 2 + ( $this->areas > 1 ? 2 : 0 ),
                'from' => $this->facility_id,
                'to' => $this->training_facility,
                'travel' => $travel,
                'lodging' => $lodging,
                'meals' => $meals,
                'cost' => ($travel['cost'] ?? 0) + $lodging + $meals,
            ]);
        }
        $this->travellers = $travellers;
        $this->cost = $this->travellers->sum('cost');
        return $this;
    }

    public function lodging($travel, $perdiem)
    {
        // Don't add lodging if less than 50 miles
        if (isset($travel['distance']) && $travel['distance'] < 50)
            return 0;

        // Get month id
        $month = strtolower($this->training_start_date->format('M'));

        // Get lodging rate for the perdiem month
        return isset($perdiem->{ $month }) ? (int)$this->perdiem->{ $month } : config('atoms.DEFAULT_LODGING_RATE');
    }

    public function meals($travel, $perdiem)
    {
        // Don't add lodging if less than 50 miles
        if (isset($travel['distance']) &&  $travel['distance'] < 50)
            return 0;

        // Calculate number of full days for trip
        $full_days = max(0, config('atoms.TRAINING_DAYS') - 2);

        // 75% first and last day plus full days
        return isset($perdiem->meals) ? ($full_days * $perdiem->meals) + ($perdiem->meals * 2 * 0.75) : config('atoms.DEFAULT_MEALS_RATE');
    }
}
