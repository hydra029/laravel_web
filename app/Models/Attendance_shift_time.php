<?php

namespace App\Models;

use App\Enums\ShiftEnum;
use App\Enums\ShiftStatusEnum;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Attendance_shift_time
 *
 * @property int $id
 * @property string $check_in_start
 * @property string $check_in_end
 * @property string $check_out_start
 * @property string $check_out_end
 * @property int $status
 * @property-read string $shifts_name
 * @property-read string $shifts_status
 * @method static Builder|Attendance_shift_time newModelQuery()
 * @method static Builder|Attendance_shift_time newQuery()
 * @method static Builder|Attendance_shift_time query()
 * @method static Builder|Attendance_shift_time whereCheckInEnd($value)
 * @method static Builder|Attendance_shift_time whereCheckInStart($value)
 * @method static Builder|Attendance_shift_time whereCheckOutEnd($value)
 * @method static Builder|Attendance_shift_time whereCheckOutStart($value)
 * @method static Builder|Attendance_shift_time whereId($value)
 * @method static Builder|Attendance_shift_time whereStatus($value)
 * @mixin Eloquent
 */
class Attendance_shift_time extends Model
{
	use HasFactory;

	public function getShiftNameAttribute(): string
	{
		return ShiftEnum::getKey($this->id);
	}

	public function getShiftStatusAttribute(): string
	{

		return ShiftStatusEnum::getKey($this->status);
	}


}
