<?php

namespace App\Models;

use App\Libraries\DistanceMatrixAPI;
use App\Traits\FacilityTrainingTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Facility
 *
 * @property int $id
 * @property string $service_area
 * @property string $district
 * @property string $facility_type
 * @property string $level
 * @property string $facility_id
 * @property string $airport_id
 * @property string $facility_name
 * @property int $areas_operational
 * @property int $areas_tmu
 * @property string $enroute_terminal
 * @property string $hr_region
 * @property int $core_airport
 * @property string $piv_readers
 * @property string $bues
 * @property int $has_wmt
 * @property int $has_preflex
 * @property int $has_postflex
 * @property int $has_siso
 * @property int $has_opq
 * @property int $release
 * @property int $release_adjusted
 * @property string $key_site
 * @property string|null $key_site_start
 * @property string $deployment_priority
 * @property string $training_date
 * @property int|null $team_id
 * @property string $training_start_date
 * @property string|null $training_facility
 * @property string $go_live_date
 * @property int|null $sibling_status
 * @property-read \App\Models\Address|null $address
 * @property-read mixed $areas
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CityPair[] $pairs_fly_from
 * @property-read int|null $pairs_fly_from_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CityPair[] $pairs_fly_to
 * @property-read int|null $pairs_fly_to_count
 * @property-read \App\Models\Perdiem|null $perdiem
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Sibling[] $siblings
 * @property-read int|null $siblings_count
 * @property-read \App\Models\Team|null $team
 * @method static \Illuminate\Database\Eloquent\Builder|Facility newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Facility newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Facility query()
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereAirportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereAreasOperational($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereAreasTmu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereBues($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereCoreAirport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereDeploymentPriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereEnrouteTerminal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereFacilityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereFacilityName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereFacilityType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereGoLiveDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereHasOpq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereHasPostflex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereHasPreflex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereHasSiso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereHasWmt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereHrRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereKeySite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereKeySiteStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility wherePivReaders($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereRelease($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereReleaseAdjusted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereServiceArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereSiblingStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereTrainingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereTrainingFacility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereTrainingStartDate($value)
 * @mixin \Eloquent
 */
class Facility extends Model
{
    use HasFactory, FacilityTrainingTrait;
    public $fillable = ['sibling_status', 'training_facility'];
    public $timestamps = FALSE;
    public $dates = ['training_date', 'training_start_date', 'go_live_date'];
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
