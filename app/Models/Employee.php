<?php

namespace App\Models;

use Database\Factories\EmployeeFactory;
use Eloquent;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * App\Models\Employee
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
 * @property string|null $remember_token
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
 * @method static EmployeeFactory factory(...$parameters)
 * @method static Builder|Employee newModelQuery()
 * @method static Builder|Employee newQuery()
 * @method static \Illuminate\Database\Query\Builder|Employee onlyTrashed()
 * @method static Builder|Employee query()
 * @method static Builder|Employee whereAvatar($value)
 * @method static Builder|Employee whereCity($value)
 * @method static Builder|Employee whereCreatedAt($value)
 * @method static Builder|Employee whereDeletedAt($value)
 * @method static Builder|Employee whereDeptId($value)
 * @method static Builder|Employee whereDistrict($value)
 * @method static Builder|Employee whereDob($value)
 * @method static Builder|Employee whereEmail($value)
 * @method static Builder|Employee whereFname($value)
 * @method static Builder|Employee whereGender($value)
 * @method static Builder|Employee whereId($value)
 * @method static Builder|Employee whereLname($value)
 * @method static Builder|Employee wherePassword($value)
 * @method static Builder|Employee wherePhone($value)
 * @method static Builder|Employee whereRememberToken($value)
 * @method static Builder|Employee whereRoleId($value)
 * @method static Builder|Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Employee withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Employee withoutTrashed()
 * @mixin Eloquent
 */
class Employee extends Model implements Authenticatable
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $guarded = [
        'id',
        'deleted_at',
        'updated_at',
        'created_at',
        'remember_token',
    ];

    public function getAgeAttribute(): string
    {
        return date_diff(date_create($this->dob), date_create())->y;
    }

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
        $in = substr($this->attendance[0]->check_in, 0,5);
        $out = substr($this->attendance[0]->check_in, 0,5);
        /** @noinspection NestedTernaryOperatorInspection */
        return ($in !== "00:00" ? ($out !== '00:00' ? $out . ' - Checked Out' : $in . ' - Checked In') : '00:00 - Not Checked');
    }

    public function getCheck2Attribute(): string
    {
        $in = substr($this->attendance[1]->check_in, 0,5);
        $out = substr($this->attendance[1]->check_in, 0,5);
        /** @noinspection NestedTernaryOperatorInspection */
        return ($in !== '00:00' ? ($out !== '00:00' ? $out . ' - Checked Out' : $in . ' - Checked In') : '00:00 - Not Checked');
    }

    public function getCheck3Attribute(): string
    {
        $in = substr($this->attendance[2]->check_in, 0,5);
        $out = substr($this->attendance[2]->check_in, 0,5);
        /** @noinspection NestedTernaryOperatorInspection */
        return ($in !== '00:00' ? ($out !== '00:00' ? $out . ' - Checked Out' : $in . ' - Checked In') : '00:00 - Not Checked');
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
        return $this->BelongsTo(Role::class,'role_id', 'id')
            ->select(['id', 'name','pay_rate']);
    }

    public function attendance(): HasMany
    {
        return $this->HasMany(Attendance::class, 'emp_id', 'id')
            ->where('emp_role', '=', 1);
    }

    public $timestamps = true;

	/**
	 * @return string
	 */
	public function getAuthIdentifierName(): string
	{
		return 'id';
	}


	public function getAuthIdentifier()
	{
		return $this->id;
	}

	public function getAuthPassword(): string
	{
		return $this->password;
	}

	public function getRememberToken(): ?string
	{
		return $this->remember_token;
	}


	public function setRememberToken($value): void
	{
		$this->remember_token = $value;
	}

	public function getRememberTokenName(): string
	{
		return 'remember_token';
	}
}
