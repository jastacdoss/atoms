<?php

namespace App\Models;

use App\Libraries\DistanceMatrixAPI;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;
    public $fillable = ['sibling_status'];
    public $timestamps = FALSE;

    /** Has a single address */
    public function address()
    {
        return $this->hasOne('App\Models\Address', 'facility_id', 'facility_id');
    }

    /** Has a single perdiem through the address/zip code */
    public function perdiem()
    {
        return $this->hasOneThrough(Perdiem::class, Address::class, 'facility_id', 'zip', 'facility_id', 'zip');
    }

    /** Can fly from many cities */
    public function pairs_fly_from()
    {
        return $this->hasMany(CityPair::class, 'FROM', 'airport_id');
    }

    /** Can fly to many cities */
    public function pairs_fly_to()
    {
        return $this->hasMany(CityPair::class, 'TO', 'airport_id');
    }

    /** Has a team for training */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function travel_to_cost($from)
    {
        // Try to find the city pair
        $pair = $this->pair_fly_to()->where('FROM', $from)->first();
        if ($pair) {
            return $pair->{config('atoms.PAIR_FARE')};
        } else {
            // See if there is already a sibling
            $sibling = $this->siblings()
                ->whereHas('sibling', fn ($q) => $q->where('facility_id', $from))
                ->first();

            // No sibling so create one
            if (!isset($sibling->sibling) || !$sibling->sibling) {
                // Find the FROM facility
                $f = Facility::where('facility_id', $from)->with('address')->first();

                // Fetch driving distance
                $distance = new DistanceMatrixAPI();
                $distance->fetch($this->address->formatted_address, $f->address->formatted_address);

                // Create a sibling
                $sibling = new Sibling();
                $sibling->sibling_id = $f->id;
                $sibling->actual_distance = $distance->distances()[0]->distance->value;
                $sibling->travel_time = $distance->distances()[0]->duration->value;
                $this->siblings()->save($sibling);
            }

            // Sibling is there so calculate driving cost
            return number_format($sibling->actual_distance * config('atoms.MILEAGE_RATE'), 2);
        }
    }

    /** Has many siblings */
    public function siblings()
    {
        return $this->hasMany(Sibling::class, 'facility_id', 'id');

    }
}
