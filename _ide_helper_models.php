<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Address
 *
 * @property int $id
 * @property string $facility_id
 * @property string $address
 * @property string $address2
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $phone
 * @property-read \App\Models\Facility $facility
 * @property-read mixed $formatted_address
 * @method static \Illuminate\Database\Eloquent\Builder|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereFacilityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereZip($value)
 * @mixin \Eloquent
 */
	class Address extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CityPair
 *
 * @property int $id
 * @property string $AWARD_YEAR
 * @property string $FROM
 * @property string $TO
 * @property string $ORIGIN_CITY_NAME
 * @property string $ORIGIN_STATE
 * @property string $ORIGIN_COUNTRY
 * @property string $DESTINATION_CITY_NAME
 * @property string $DESTINATION_STATE
 * @property string $DESTINATION_COUNTRY
 * @property string $AIRLINE_ABBREV
 * @property string $AWARDED_SERV
 * @property string $PAX_COUNT
 * @property string $YCA_FARE
 * @property string $XCA_FARE
 * @property string $BUSINESS_FARE
 * @property string $ORIGIN_AIRPORT_LOCATION
 * @property string $DESTINATION_AIRPORT_LOCATION
 * @property string $ORIGIN_CITY_STATE_AIRPORT
 * @property string $DESTINATION_CITY_STATE_AIRPORT
 * @property string $EFFECTIVE_DATE
 * @property string $EXPIRATION_DATE
 * @method static \Illuminate\Database\Eloquent\Builder|CityPair newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CityPair newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CityPair query()
 * @method static \Illuminate\Database\Eloquent\Builder|CityPair whereAIRLINEABBREV($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityPair whereAWARDEDSERV($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityPair whereAWARDYEAR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityPair whereBUSINESSFARE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityPair whereDESTINATIONAIRPORTLOCATION($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityPair whereDESTINATIONCITYNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityPair whereDESTINATIONCITYSTATEAIRPORT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityPair whereDESTINATIONCOUNTRY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityPair whereDESTINATIONSTATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityPair whereEFFECTIVEDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityPair whereEXPIRATIONDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityPair whereFROM($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityPair whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityPair whereORIGINAIRPORTLOCATION($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityPair whereORIGINCITYNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityPair whereORIGINCITYSTATEAIRPORT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityPair whereORIGINCOUNTRY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityPair whereORIGINSTATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityPair wherePAXCOUNT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityPair whereTO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityPair whereXCAFARE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityPair whereYCAFARE($value)
 * @mixin \Eloquent
 */
	class CityPair extends \Eloquent {}
}

namespace App\Models{
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
 * @property string $training_dead_date
 * @property string|null $notification_dead_date
 * @property string|null $poc_training_dead_date
 * @property-read Facility|null $training
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereNotificationDeadDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility wherePocTrainingDeadDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereTrainingDeadDate($value)
 */
	class Facility extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Perdiem
 *
 * @property int $id
 * @property string $destination_id
 * @property string $name
 * @property string $location
 * @property string $state
 * @property string $zip
 * @property string $fiscal
 * @property string $oct
 * @property string $nov
 * @property string $dec
 * @property string $jan
 * @property string $feb
 * @property string $mar
 * @property string $apr
 * @property string $may
 * @property string $jun
 * @property string $jul
 * @property string $aug
 * @property string $sep
 * @property string $meals
 * @method static \Illuminate\Database\Eloquent\Builder|Perdiem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Perdiem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Perdiem query()
 * @method static \Illuminate\Database\Eloquent\Builder|Perdiem whereApr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perdiem whereAug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perdiem whereDec($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perdiem whereDestinationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perdiem whereFeb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perdiem whereFiscal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perdiem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perdiem whereJan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perdiem whereJul($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perdiem whereJun($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perdiem whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perdiem whereMar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perdiem whereMay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perdiem whereMeals($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perdiem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perdiem whereNov($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perdiem whereOct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perdiem whereSep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perdiem whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perdiem whereZip($value)
 * @mixin \Eloquent
 */
	class Perdiem extends \Eloquent {}
}

namespace App\Models{
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
 * @property-read mixed $distance_miles
 * @property-read mixed $travel_time_minutes
 */
	class Sibling extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Team
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Facility[] $facilities
 * @property-read int|null $facilities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TeamMember[] $members
 * @property-read int|null $members_count
 * @method static \Illuminate\Database\Eloquent\Builder|Team newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team query()
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Team extends \Eloquent {}
}

namespace App\Models{
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
	class TeamMember extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class User extends \Eloquent {}
}

