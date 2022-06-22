<?php

namespace App\Models;

use Database\Factories\CeoFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Ceo
 *
 * @property int $id
 * @property string $fname
 * @property string $lname
 * @property int $gender
 * @property string $dob
 * @property string $email
 * @property string $password
 * @method static CeoFactory factory(...$parameters)
 * @method static Builder|Ceo newModelQuery()
 * @method static Builder|Ceo newQuery()
 * @method static Builder|Ceo query()
 * @method static Builder|Ceo whereDob($value)
 * @method static Builder|Ceo whereEmail($value)
 * @method static Builder|Ceo whereFname($value)
 * @method static Builder|Ceo whereGender($value)
 * @method static Builder|Ceo whereId($value)
 * @method static Builder|Ceo whereLname($value)
 * @method static Builder|Ceo wherePassword($value)
 * @mixin Eloquent
 */
class Ceo extends Model
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
