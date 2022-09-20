<?php

namespace App\Models;

use Database\Factories\AccountantFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * App\Models\Accountant
 *
 * @property int $id
 * @property string $fname
 * @property string $lname
 * @property int $gender
 * @property string $dob
 * @property string|null $avatar
 * @property string $city
 * @property string $district
 * @property string $phone
 * @property string $email
 * @property string|null $password
 * @property int $dept_id
 * @property int $role_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection|Attendance[] $attendance
 * @property-read int|null $attendance_count
 * @property-read Department $departments
 * @property-read string $address
 * @property-read string $age
 * @property-read string $check1
 * @property-read string $check2
 * @property-read string $check3
 * @property-read string $date
 * @property-read string $date_of_birth
 * @property-read string $full_name
 * @property-read string $gender_name
 * @property-read string $role_name
 * @property-read string $shift_status
 * @property-read Role $roles
 * @property-read Collection|PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static AccountantFactory factory(...$parameters)
 * @method static Builder|Accountant newModelQuery()
 * @method static Builder|Accountant newQuery()
 * @method static \Illuminate\Database\Query\Builder|Accountant onlyTrashed()
 * @method static Builder|Accountant query()
 * @method static Builder|Accountant whereAvatar($value)
 * @method static Builder|Accountant whereCity($value)
 * @method static Builder|Accountant whereCreatedAt($value)
 * @method static Builder|Accountant whereDeletedAt($value)
 * @method static Builder|Accountant whereDeptId($value)
 * @method static Builder|Accountant whereDistrict($value)
 * @method static Builder|Accountant whereDob($value)
 * @method static Builder|Accountant whereEmail($value)
 * @method static Builder|Accountant whereFname($value)
 * @method static Builder|Accountant whereGender($value)
 * @method static Builder|Accountant whereId($value)
 * @method static Builder|Accountant whereLname($value)
 * @method static Builder|Accountant wherePassword($value)
 * @method static Builder|Accountant wherePhone($value)
 * @method static Builder|Accountant whereRoleId($value)
 * @method static Builder|Accountant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Accountant withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Accountant withoutTrashed()
 * @mixin Eloquent
 */
class Accountant extends Model
{
    use HasFactory, SoftDeletes, HasApiTokens;

	protected $guarded = [
		'id',
		'deleted_at',
		'updated_at',
		'created_at',
		'remember_token',
	];

    public function getAddressAttribute(): string
    {
	    return $this->district . ' - ' . $this->city;
    }

	public function getDateOfBirthAttribute(): string
	{
		return date_format(date_create($this->dob), "d/m/Y");
	}

	public function getShortDobAttribute(): string
	{
		return date_format(date_create($this->dob), 'Y-m-d');
	}

	public function getDateAttribute(): string
	{
		return date_format(date_create(), 'D d-m-Y');
	}

    public function getAgeAttribute(): string
    {
        return date_diff(date_create($this->dob), date_create())->y;
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


    public function departments(): BelongsTo
    {
        return $this->BelongsTo(Department::class, 'dept_id', 'id')
            ->select(['id', 'name']);
    }

    public function roles(): BelongsTo
    {
        return $this->BelongsTo(Role::class, 'role_id', 'id')
            ->select(['id', 'name','pay_rate']);
    }

    public function attendance(): HasMany
    {
        return $this->HasMany(Attendance::class, 'emp_id', 'id')
            ->where('emp_role', '=', 3);
    }
}
