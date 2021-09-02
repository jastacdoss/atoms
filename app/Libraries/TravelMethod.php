<?php

namespace App\Libraries;

use App\Models\CityPair;
use App\Models\Facility;
use App\Models\Sibling;
use App\Models\Team;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Identify method of transportation and cost between two facilities
 *
 * Class TravelMethod
 * @package App\Libraries
 */
class TravelMethod
{
    /**
     * FROM facilityu
     * @var Facility $from
     */
    private Facility $from;

    /**
     * TO Facility
     *
     * @var Facility $to
     */
    private Facility $to;

    /**
     * Result
     *
     * @var array
     */
    public $result = [
        'cost' => '',
        'method' => '',
        'estimate' => FALSE,
        'pair' => NULL, // If a city pair is found
    ];

    /**
     * Set the FROM for travel
     * @param Facility $facility
     * @return $this
     */
    public function from(Facility $facility)
    {
        $this->from = $facility;
        return $this;
    }

    /**
     * Set the TO for travel
     *
     * @param Facility $facility
     * @return $this
     */
    public function to(Facility $facility)
    {
        $this->to = $facility;
        return $this;
    }

    /**
     * Store the method and return
     *
     * @param $cost
     * @param $method
     * @param false $estimate
     * @param false $pair
     * @return array
     */
    public function set_method($cost, $method, $estimate = FALSE, $pair = FALSE)
    {
        $this->result['cost'] = (float)$cost;
        $this->result['method'] = $method;
        $this->result['estimate'] = $estimate;
        $this->result['pair'] = $pair;

        return $this->result;
    }

    /**
     * Determine the cost to travel from a facility to another facility
     *
     * @return array
     */
    public function calculate()
    {
        return Cache::tags('travel-method')
            ->remember($this->from->facility_id . '-' . $this->to->facility_id, 3600, function () {

            // Look for city pair
            $pair = $this->find_city_pair($this->from, $this->to);

            // See if travelling to local airport
            if ($pair) {
                // Pair found
                return $this->set_method($pair['pair']->{config('atoms.PAIR_FARE')} * 2, 'air', FALSE, $pair);
            }

            // See if POV is an option
            $pov = $this->from->siblings()
                ->where('sibling_id', $this->to->id)
                ->orderBy('actual_distance')
                ->first();
            if ($pov) {
                // They can just drive
                return $this->set_method($this->pov_mileage($pov), 'pov');
            }

            // No other option so just estimate
            return $this->set_method(config('atoms.DEFAULT_AIRFARE'), 'air', TRUE);
        });
    }

    /**
     * Calculate POV mileage allowance for driving to local facility
     *
     * @param Sibling $sibling
     * @return string
     */
    public function pov_mileage(Sibling $sibling)
    {
        return number_format($sibling->actual_distance * config('atoms.MILEAGE_RATE'), 2);
    }

    /**
     * Find city pairs for specified facilities or siblings
     *
     * @param Facility $from
     * @param Facility $to
     * @return null
     */
    public function find_city_pair(Facility $from, Facility $to)
    {
        // See if city pair exists
        $pair = $from->pairs_fly_from()->where('TO', $to->facility_id)->first();
        if ($pair) {
            return [
                'pair' => $pair,
                'is_exact' => TRUE,
                ];
        }

        /** No pair so find sibling that works - closest first */
        // Get sibling airports
        $from_siblings = $from->siblings()->with('sibling')->orderBy('actual_distance')->get();;
        $to_siblings = $to->siblings()->with('sibling')->orderBy('actual_distance')->get();

        // Look for nearby airport on departure
        foreach ($to_siblings->pluck('sibling.facility_id') as $to_id) {
            // If pair found then return it
            $pair = CityPair::whereIn('FROM', $from_siblings->pluck('sibling.facility_id'))->where('TO', $to_id)->first();
            if ($pair)
                return [
                    'pair' => $pair,
                    'siblings' => [
                        'from' => $from_siblings->where('sibling.facility_id', $pair->FROM)->first(),
                        'to' => $to_siblings->where('sibling.facility_id', $pair->TO)->first(),
                    ],
                    'is_exact' => FALSE,
                ];
        }

        // Return null if none found
        return NULL;
    }

}
