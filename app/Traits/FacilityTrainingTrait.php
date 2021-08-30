<?php
namespace App\Traits;


use App\Libraries\TravelMethod;
use Illuminate\Support\Collection;

trait FacilityTrainingTrait {
    public function whos_travelling()
    {
        // Set up training collection
        $travellers = new Collection();

        // See if trainers are on-site or trainees are travelling
        if ($this->facility_id === $this->training_facility) {
            /** Trainers travelling to facility */
            // Get trainers
            $trainers = $this->team->members;

            // Create new travel method object
            $d = new TravelMethod();
            foreach($trainers as $trainer) {
                $travellers->push([
                    'who' => 'trainers',
                    'cost' => $d->to($this)->from($trainer->facility)->calculate(),
                    'how_many' => 1,
                ]);
            }
        } else {
            /** Trainees are travelling to another location */
            $d = new TravelMethod();
            $travellers->push([
                'who' => 'trainees',
                'cost' => $d->to($this->training)->from($this)->calculate(),
                'how_many' => $this->areas * 2 + ( $this->areas > 1 ? 2 : 0 ),
            ]);
        }
        return $travellers;
    }
}
