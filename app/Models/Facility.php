<?php

namespace App\Models;

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
    public function pair_fly_from()
    {
        return $this->hasMany(CityPair::class, 'FROM', 'airport_id');
    }

    /** Can fly to many cities */
    public function pair_fly_to()
    {
        return $this->hasMany(CityPair::class, 'TO', 'airport_id');
    }

    /** Has many siblings */
    public function siblings()
    {
        return $this->hasMany(Sibling::class, 'facility_id', 'id');
    }
}
