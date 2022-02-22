<?php

namespace App\Models;

use App\Libraries\DistanceMatrixAPI;
use App\Traits\FacilityTrainingTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory, FacilityTrainingTrait;
    public $fillable = ['sibling_status', 'training_facility', 'go_live_date'];
    public $timestamps = FALSE;
    public $dates = ['training_dead_date', 'training_start_date', 'go_live_date', 'notification_dead_date', 'poc_training_dead_date'];
    public $appends = ['areas'];

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

    /** Has many siblings */
    public function siblings()
    {
        return $this->hasMany(Sibling::class, 'facility_id', 'id');
    }

    /** Training is at a facility */
    public function training()
    {
        return $this->hasOne(Facility::class, 'facility_id', 'training_facility');
    }

    /** Get number of areas */
    public function getAreasAttribute()
    {
        return $this->areas_operational + $this->areas_tmu;
    }
}
