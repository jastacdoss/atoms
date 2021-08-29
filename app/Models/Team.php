<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    /** Has members */
    public function members()
    {
        return $this->hasMany(TeamMember::class);
    }

    /** Has facilities of responsibility */
    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }
}
