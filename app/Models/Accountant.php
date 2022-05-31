<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 * @method static \Database\Factories\AccountantFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant query()
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant whereDeptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant whereFname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant whereLname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant whereStatus($value)
 * @mixin \Eloquent
 */
class Accountant extends Model
{
    use HasFactory;
	public $timestamps = false;

}
