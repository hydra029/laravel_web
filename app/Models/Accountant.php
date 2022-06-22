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
 */
class Accountant extends Model
{
    use HasFactory;

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
