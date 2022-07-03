<?php

namespace App\Models;

use Database\Factories\EmployeeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Employee
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
 * @property-read string $age
 * @property-read string $full_name
 * @property-read string $gender_name
 * @method static EmployeeFactory factory(...$parameters)
 * @method static Builder|Employee newModelQuery()
 * @method static Builder|Employee newQuery()
 * @method static Builder|Employee query()
 * @method static Builder|Employee paginate()
 * @method static Builder|Employee whereDeptId($value)
 * @method static Builder|Employee whereDob($value)
 * @method static Builder|Employee whereEmail($value)
 * @method static Builder|Employee whereFname($value)
 * @method static Builder|Employee whereGender($value)
 * @method static Builder|Employee whereId($value)
 * @method static Builder|Employee whereLname($value)
 * @method static Builder|Employee wherePassword($value)
 * @method static Builder|Employee whereRoleId($value)
 * @method static Builder|Employee whereStatus($value)
 * @mixin Eloquent
 * @property-read string $date
 * @property-read string $shift_status
 * @property-read string $check_in_1
 * @property-read string $check_in_2
 * @property-read string $check_in_3
 * @property-read string $check_out_1
 * @property-read string $check_out_2
 * @property-read string $check_out_3
 */
class Employee extends Model
{
	use HasFactory;

	protected $fillable = [
		'fname',
		'lname',
		'gender',
		'dob',
		'email',
		'password',
		'dept_id',
		'role_id',
	];

	/**
	 *
	 * @return string
	 */
	public function getAgeAttribute(): string
	{
		return date_diff(date_create($this->dob), date_create())->y;
	}

	public function getDateAttribute(): string
	{
		return date_format(date_create(), 'D d-m-Y');
	}

	public function getFullNameAttribute(): string
	{
		return $this->fname . ' ' . $this->lname;
	}

	public function getGenderNameAttribute(): string
	{
		return ($this->gender === 1 ? 'Male' : 'Female');
	}

	public function getDeptNameAttribute(): string
	{
		$dept_id = $this->dept_id;
		$dept_name = Department::whereId($dept_id)->get('name');
		return $dept_name[0]['name'];
	}

	public function getRoleNameAttribute(): string
	{
		$role_id = $this->role_id;
		$role_name = Department::whereId($role_id)->get('name');
		return $role_name[0]['name'];
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

	public function getCheck1Attribute(): string
	{
		/** @noinspection NestedTernaryOperatorInspection */
		/** @noinspection PhpStrictComparisonWithOperandsOfDifferentTypesInspection */
		return ($this->check_in_1 === 1 ? ($this->check_out_1 === 1 ? 'Checked Out' : 'Checked In') : 'Not Checked');
	}

	public function getCheck2Attribute(): string
	{
		/** @noinspection NestedTernaryOperatorInspection */
		/** @noinspection PhpStrictComparisonWithOperandsOfDifferentTypesInspection */
		return ($this->check_in_2 === 1 ? ($this->check_out_2 === 1 ? 'Checked Out' : 'Checked In') : 'Not Checked');
	}

	public function getCheck3Attribute(): string
	{
		/** @noinspection NestedTernaryOperatorInspection */
		/** @noinspection PhpStrictComparisonWithOperandsOfDifferentTypesInspection */
		return ($this->check_in_3 === 1 ? ($this->check_out_3 === 1 ? 'Checked Out' : 'Checked In') : 'Not Checked');
	}

	public function departments(): BelongsTo
	{
		return $this->BelongsTo(Department::class, 'dept_id', 'id')
			->select(['id', 'name as dept_name'])
			->where('status', '=', 1);
	}

	public function roles(): BelongsTo
	{
		return $this->BelongsTo(Role::class, 'role_id', 'id')
			->select(['id', 'name'])
			->where('status', '=', 1);
	}

	public $timestamps = false;
}
