<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
class Perdiem extends Model
{
    use HasFactory;

}
