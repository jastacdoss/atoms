<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Sibling
 *
 * @property int $id
 * @property int $facility_id
 * @property int|null $sibling_id
 * @property mixed|null $zip_distance
 * @property mixed|null $actual_distance
 * @property int|null $travel_time
 * @property-read \App\Models\Facility $parent
 * @property-read \App\Models\Facility|null $sibling
 * @method static \Illuminate\Database\Eloquent\Builder|Sibling newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sibling newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sibling query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sibling whereActualDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sibling whereFacilityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sibling whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sibling whereSiblingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sibling whereTravelTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sibling whereZipDistance($value)
 * @mixin \Eloquent
 */
class Sibling extends Model
{
    use HasFactory;

    public $timestamps = FALSE;
    public $fillable = ['facility_id', 'sibling_id', 'zip_distance', 'actual_distance'];
    protected $casts = [
        'zip_distance' => 'decimal:5',
        'actual_distance' => 'decimal:5',
    ];

    /** Has a parent facility */
    public function parent()
    {
        return $this->belongsTo(Facility::class, 'facility_id', 'id');
    }

    /** Sibling facility */
    public function sibling()
    {
        return $this->belongsTo(Facility::class, 'sibling_id', 'id');
    }

    /** Return distance in miles */
    public function getActualDistanceAttribute($value)
    {
        // Convert meters to miles
        return $value * config('atoms.METERS_TO_MILES');
    }
}
