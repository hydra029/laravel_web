<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Check
 *
 * @property string $date
 * @property int $emp_id
 * @property int $shift
 * @property int $check_in
 * @property int $check_out
 * @method static \Database\Factories\CheckFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Check newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Check newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Check query()
 * @method static \Illuminate\Database\Eloquent\Builder|Check whereCheckIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Check whereCheckOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Check whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Check whereEmpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Check whereShift($value)
 * @mixin \Eloquent
 */
class Check extends Model
{
    use HasFactory;
	public $timestamps = false;

}
