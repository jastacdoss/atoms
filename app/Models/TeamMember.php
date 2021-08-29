<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    /** Has a user profile */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /** Flies out of an airport */
    public function facility()
    {
        return $this->hasOne(Facility::class, 'facility_id', 'airport_id');
    }
}
