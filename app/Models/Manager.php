<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Manager
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
 * @method static \Database\Factories\ManagerFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Manager newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Manager query()
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereDeptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereFname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereLname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereStatus($value)
 * @mixin \Eloquent
 */
class Manager extends Model
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

	public $timestamps = false;

}
