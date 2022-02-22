<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TeamMember
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string $airport_id
 * @property int $team_id
 * @property int|null $user_id
 * @property-read \App\Models\Facility|null $facility
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereAirportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereUserId($value)
 * @mixin \Eloquent
 */
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
