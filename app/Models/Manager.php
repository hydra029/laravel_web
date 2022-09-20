<?php

namespace App\Models;

use Database\Factories\ManagerFactory;
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
 * App\Models\Manager
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
 * @property-read string $date_of_birth
 * @property-read string $full_name
 * @property-read string $gender_name
 * @property-read Role $roles
 * @property-read Collection|Salary[] $salary
 * @property-read int|null $salary_count
 * @property-read Collection|PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static ManagerFactory factory(...$parameters)
 * @method static Builder|Manager newModelQuery()
 * @method static Builder|Manager newQuery()
 * @method static \Illuminate\Database\Query\Builder|Manager onlyTrashed()
 * @method static Builder|Manager query()
 * @method static Builder|Manager whereAvatar($value)
 * @method static Builder|Manager whereCity($value)
 * @method static Builder|Manager whereCreatedAt($value)
 * @method static Builder|Manager whereDeletedAt($value)
 * @method static Builder|Manager whereDeptId($value)
 * @method static Builder|Manager whereDistrict($value)
 * @method static Builder|Manager whereDob($value)
 * @method static Builder|Manager whereEmail($value)
 * @method static Builder|Manager whereFname($value)
 * @method static Builder|Manager whereGender($value)
 * @method static Builder|Manager whereId($value)
 * @method static Builder|Manager whereLname($value)
 * @method static Builder|Manager wherePassword($value)
 * @method static Builder|Manager wherePhone($value)
 * @method static Builder|Manager whereRoleId($value)
 * @method static Builder|Manager whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Manager withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Manager withoutTrashed()
 * @mixin Eloquent
 */
class Manager extends Model
{
    use HasFactory, SoftDeletes, HasApiTokens;

	protected $guarded = [
		'id',
		'deleted_at',
		'updated_at',
		'created_at',
		'remember_token',
	];

    public function getDateOfBirthAttribute(): string
    {
        return date_format(date_create($this->dob),"d/m/Y");
    }

	public function getShortDobAttribute(): string
	{
		return date_format(date_create($this->dob), 'Y-m-d');
	}

    public function getAddressAttribute(): string
    {
        return $this->district . ' - ' . $this->city ;
    }

	public function getAgeAttribute(): string
	{
		return date_diff(date_create($this->dob), date_create())->y;
	}

	public function getFullNameAttribute(): string
	{
		return $this->fname . ' ' . $this->lname;
	}

	public function getGenderNameAttribute(): string
	{

		return ($this->gender === 1 ? 'Male' : 'Female');
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
            ->where('emp_role', '=', 2);
    }

    public function salary(): HasMany
    {
		$dept_name = Department::where('id', '=', $this->dept_id)->first();
	    $month    = date('m', strtotime('last month'));
	    $year     = date('Y', strtotime('last month'));
        return $this->HasMany(Salary::class, 'emp_id', 'id')
            ->where('emp_role', '=', 2)
            ->where('month', '=', $month)
            ->where('year', '=', $year);
    }


}
