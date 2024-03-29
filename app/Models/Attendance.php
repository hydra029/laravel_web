<?php

namespace App\Models;

use App\Enums\ShiftEnum;
use App\Enums\ShiftStatusEnum;
use Database\Factories\AttendanceFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

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
 * @property-read string $check_in_time
 * @property-read string $check_out_time
 * @property-read string $in_end
 * @property-read string $in_start
 * @property-read string $out_end
 * @property-read string $out_start
 * @property-read AttendanceShiftTime|null $shifts
 */
class Attendance extends Model
{
	use HasFactory, HasCompositeKey;

	public    $timestamps = false;
	protected $fillable   = [
		'emp_id',
		'shift',
		'date',
		'check_in',
		'check_out',
		'emp_role',
	];
	protected $primaryKey = [
		'date',
		'emp_id',
		'emp_role',
		'shift',
	];
	protected $casts      = [
		'date' => 'timestamp:d-m-Y',
	];

	public function getShiftNameAttribute(): string
	{
		return ShiftEnum::getKeybyValue($this->shift);
	}

	public function getShiftStatusAttribute(): string
	{
		return ShiftStatusEnum::getKeybyValue($this->shifts->status);
	}

	public function getInStartAttribute(): string
	{
		return substr($this->shifts->check_in_start, 0, 5);
	}

	public function getInEndAttribute(): string
	{
		return substr($this->shifts->check_in_late_2, 0, 5);
	}

	public function getOutStartAttribute(): string
	{
		return substr($this->shifts->check_out_early_1, 0, 5);
	}

	public function getOutEndAttribute(): string
	{
		return substr($this->shifts->check_out_end, 0, 5);
	}

	public function getCheckInTimeAttribute(): string
	{
		return substr($this->check_in, 0, 5);
	}

	public function getCheckOutTimeAttribute(): string
	{
		return substr($this->check_out, 0, 5);
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
