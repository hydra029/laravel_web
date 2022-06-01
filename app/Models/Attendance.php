<?php

namespace App\Models;

use Database\Factories\AttendanceFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Attendance
 *
 * @property string $date
 * @property int $emp_id
 * @property int $shift
 * @property int $check_in
 * @property int $check_out
 * @method static AttendanceFactory factory(...$parameters)
 * @method static Builder|Attendance newModelQuery()
 * @method static Builder|Attendance newQuery()
 * @method static Builder|Attendance query()
 * @method static Builder|Attendance whereCheckIn($value)
 * @method static Builder|Attendance whereCheckOut($value)
 * @method static Builder|Attendance whereDate($value)
 * @method static Builder|Attendance whereEmpId($value)
 * @method static Builder|Attendance whereShift($value)
 * @mixin Eloquent
 */
class Attendance extends Model
{
    use HasFactory;
	public $timestamps = false;
	protected $fillable = [
		'emp_id',
		'shift',
		'date',
		'check_in',
		'check_out',
	];
	protected $casts = [
		'date' => 'timestamp:d-m-Y',
	];
}
