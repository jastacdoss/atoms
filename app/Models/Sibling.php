<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
