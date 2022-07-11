<?php

namespace App\Models;

use Database\Factories\AccountantFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Accountant
 *
 * @property int $id
 * @property string $fname
 * @property string $lname
 * @property int $gender
 * @property string $dob
 * @property string $email
 * @property string $password
 * @property int $dept_id
 * @property int $role_id
 * @property int $status
 * @method static AccountantFactory factory(...$parameters)
 * @method static Builder|Accountant newModelQuery()
 * @method static Builder|Accountant newQuery()
 * @method static Builder|Accountant query()
 * @method static Builder|Accountant whereDeptId($value)
 * @method static Builder|Accountant whereDob($value)
 * @method static Builder|Accountant whereEmail($value)
 * @method static Builder|Accountant whereFname($value)
 * @method static Builder|Accountant whereGender($value)
 * @method static Builder|Accountant whereId($value)
 * @method static Builder|Accountant whereLname($value)
 * @method static Builder|Accountant wherePassword($value)
 * @method static Builder|Accountant whereRoleId($value)
 * @method static Builder|Accountant whereStatus($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Department|null $department
 * @property-read \App\Models\Role|null $role
 */
class Accountant extends Model
{
    use HasFactory;

	protected $fillable = [
		'fname',
		'lname',
		'gender',
		'dob',
        'avatar',
        'phone',
        'city',
        'district',
		'email',
		'password',
		'dept_id',
		'role_id',
        'status',
	];

    public function getAddressAttribute(): string
    {
        return $this->district . ' ' . $this->city ;
    }

	public function getDateOfBirthAttribute(): string
	{
		return date_format(date_create($this->dob), "d/m/Y");
	}

	public function getDateAttribute(): string
	{
		return date_format(date_create(), 'D d-m-Y');
	}

	public function getFullNameAttribute(): string
	{
		return $this->fname . ' ' . $this->lname;
	}

	public function getRoleNameAttribute(): string
	{
		return $this->roles->name;
	}

	public function getGenderNameAttribute(): string
	{
		return ($this->gender === 1 ? 'Male' : 'Female');
	}

	public function getCheck1Attribute(): string
	{
		/** @noinspection NestedTernaryOperatorInspection */
		return ($this->attendance[0]->check_in === 1 ? ($this->attendance[0]->check_out === 1 ? 'Checked Out' : 'Checked In') : 'Not Checked');
	}

	public function getCheck2Attribute(): string
	{
		/** @noinspection NestedTernaryOperatorInspection */
		return ($this->attendance[1]->check_in === 1 ? ($this->attendance[1]->check_out === 1 ? 'Checked Out' : 'Checked In') : 'Not Checked');
	}

	public function getCheck3Attribute(): string
	{
		/** @noinspection NestedTernaryOperatorInspection */
		return ($this->attendance[2]->check_in === 1 ? ($this->attendance[2]->check_out === 1 ? 'Checked Out' : 'Checked In') : 'Not Checked');
	}

	public function getShiftStatusAttribute(): string
	{
		$status = "";
		$date = date('Y-m-d');
		$shift_status = AttendanceShiftTime::get('id');
		foreach ($shift_status as $each) {
			$shift = $each->id;
			$emp_id = $this->id;
			$attendances = Attendance::where('date', '=', $date)
				->where('shift', '=', $shift)
				->where('emp_role', '=', 1)
				->where('emp_id', '=', $emp_id)
				->get();
			foreach ($attendances as $attendance) {
				$check_in = $attendance->check_in;
				$check_out = $attendance->check_out;
				if ($check_in !== 1) {
					if ($check_out !== 1) {
						$status = 'Not checked yet';
					} else {
						$status = 'Checked out';
					}
				} else {
					$status = 'Checked in';
				}
			}
		}
		return $status;
	}


	public function department(): HasOne
	{
		return $this->hasOne(Department::class, 'dept_id');
	}
	public function role(): HasOne
	{
		return $this->hasOne(Role::class, 'role_id');
	}

	public $timestamps = false;
}
