<?php

namespace App\Models;

use App\Enums\AttendanceEnum;
use App\Enums\ShiftEnum;
use App\Enums\ShiftStatusEnum;
use Database\Factories\AttendanceFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Attendance
 *
 * @property string $date
 * @property string $emp
 * @property string $fname
 * @property string $lname
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
 * @property-read Accountant|null $acct
 * @property-read string $full_name
 * @property-read Manager|null $mgr
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
		return ShiftEnum::getKey($this->shift);
	}

	public function getShiftStatusAttribute(): string
	{
		return ShiftStatusEnum::getKey($this->shifts->status);
	}

	public function getCheckInTimeAttribute(): string
	{
		return substr($this->check_in,0,5);
	}

	public function getCheckOutTimeAttribute(): string
	{
        return substr($this->check_out,0,5);
	}


	public function emp(): BelongsTo
	{
		return $this->BelongsTo(Employee::class, 'emp_id')
			->select(['id', 'fname', 'lname', 'gender', 'dob', 'email', 'dept_id', 'role_id']);
	}

	public function mgr(): BelongsTo
	{
		return $this->BelongsTo(Manager::class, 'emp_id');
	}

	public function acct(): BelongsTo
	{
		return $this->BelongsTo(Accountant::class, 'emp_id');
	}

	public function shifts(): BelongsTo
	{
		return $this->BelongsTo(AttendanceShiftTime::class, 'shift');
	}


}
