<?php

namespace App\Models;

use App\Enums\ShiftEnum;
use App\Enums\ShiftStatusEnum;
use Database\Factories\AttendanceShiftTimeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AttendanceShiftTime
 *
 * @property int $id
 * @property string $check_in_start
 * @property string $check_in_end
 * @property string $check_in_late_1
 * @property string $check_in_late_2
 * @property string $check_out_early_1
 * @property string $check_out_early_2
 * @property string $check_out_start
 * @property string $check_out_end
 * @property int $status
 * @property-read string $shifts_name
 * @property-read string $shifts_status
 * @method static Builder|AttendanceShiftTime newModelQuery()
 * @method static Builder|AttendanceShiftTime newQuery()
 * @method static Builder|AttendanceShiftTime query()
 * @method static Builder|AttendanceShiftTime whereCheckInEnd($value)
 * @method static Builder|AttendanceShiftTime whereCheckInStart($value)
 * @method static Builder|AttendanceShiftTime whereCheckOutEnd($value)
 * @method static Builder|AttendanceShiftTime whereCheckOutStart($value)
 * @method static Builder|AttendanceShiftTime whereId($value)
 * @method static Builder|AttendanceShiftTime whereStatus($value)
 * @mixin Eloquent
 * @property-read string $in_end
 * @property-read string $in_start
 * @property-read string $name
 * @property-read string $out_end
 * @property-read string $out_start
 * @property-read string $shift_name
 * @property-read string $shift_status
 * @property-read string $in_late1
 * @property-read string $in_late2
 * @property-read string $out_early1
 * @property-read string $out_early2
 * @method static AttendanceShiftTimeFactory factory(...$parameters)
 * @method static Builder|AttendanceShiftTime whereCheckInLate1($value)
 * @method static Builder|AttendanceShiftTime whereCheckInLate2($value)
 * @method static Builder|AttendanceShiftTime whereCheckOutEarly1($value)
 * @method static Builder|AttendanceShiftTime whereCheckOutEarly2($value)
 */
class AttendanceShiftTime extends Model
{
	use HasFactory;

	public $timestamps = false;
	protected $fillable = [
		'id',
		'check_in_start',
		'check_in_end',
		'check_in_late_1',
		'check_in_late_2',
		'check_out_early_1',
		'check_out_early_2',
		'check_out_start',
		'check_out_end',
		'status',
	];

	public function getShiftNameAttribute(): string
	{
		return ShiftEnum::getKeyByValue($this->id);
	}

	public function getShiftStatusAttribute(): string
	{
		return ShiftStatusEnum::getKeyByValue($this->status);
	}

	public function getInStartAttribute(): string
	{
		return date('H:i', strtotime($this->check_in_start));
	}

	public function getInEndAttribute(): string
	{
		return date('H:i', strtotime($this->check_in_end));
	}

	public function getInLate1Attribute(): string
	{
		return date('H:i', strtotime($this->check_in_late_1));
	}

	public function getInLate2Attribute(): string
	{
		return date('H:i', strtotime($this->check_in_late_2));
	}

	public function getOutEarly1Attribute(): string
	{
		return date('H:i', strtotime($this->check_out_early_1));
	}

	public function getOutEarly2Attribute(): string
	{
		return date('H:i', strtotime($this->check_out_early_2));
	}

	public function getOutStartAttribute(): string
	{
		return date('H:i', strtotime($this->check_out_start));
	}

	public function getOutEndAttribute(): string
	{
		return date('H:i', strtotime($this->check_out_end));
	}

}
