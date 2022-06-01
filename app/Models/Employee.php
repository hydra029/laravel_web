<?php

namespace App\Models;

use Database\Factories\EmployeeFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 * @mixin \Eloquent
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
		return date_format(date_create(),'D d-m-Y');
	}

	public function getFullNameAttribute(): string
	{
		return $this->fname . ' ' . $this->lname;
	}

	public function getGenderNameAttribute(): string
	{

		return ($this->gender === 1 ? 'Male' : 'Female');
	}

	public $timestamps = false;
}
