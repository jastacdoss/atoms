<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
class CityPair extends Model
{
    use HasFactory;
}
