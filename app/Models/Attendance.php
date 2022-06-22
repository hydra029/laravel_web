<?php

namespace App\Models;

use App\Enums\AttendanceEnum;
use App\Enums\ShiftEnum;
use App\Enums\ShiftStatusEnum;
use App\Http\Controllers\AttendanceShiftTimeController;
use Database\Factories\AttendanceFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Attendance
 *
 * @property string $date
 * @property int $emp_id
 * @property int $shift_id
 * @property int $shift
 * @property int $status
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
 * @property int $emp_role
 * @property-read string $check_in_status
 * @property-read string $check_out_status
 * @method static Builder|Attendance whereEmpRole($value)
 * @property-read string $shift_name
 * @property-read string $shift_status
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

	public function getShiftNameAttribute(): string
	{
		return ShiftEnum::getKey($this->shift_id);
	}

	public function getShiftStatusAttribute(): string
	{

		return ShiftStatusEnum::getKey($this->status);
	}
	public function getCheckInStatusAttribute(): string
	{
		return AttendanceEnum::getKey($this->check_in);
	}
	public function getCheckOutStatusAttribute(): string
	{
		return AttendanceEnum::getKey($this->check_out);
	}

	public function emp(): HasMany
	{
		return $this->hasMany(Employee::class, 'emp_id');
	}
	public function mgr(): HasMany
	{
		return $this->hasMany(Manager::class, 'emp_id');
	}
	public function acct(): HasMany
	{
		return $this->hasMany(Accountant::class, 'emp_id');
	}
	public function shift(): HasMany
	{
		return $this->hasMany(Attendance_shift_time::class, 'shift');
	}

}
