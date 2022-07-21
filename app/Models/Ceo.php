<?php

namespace App\Models;

use Database\Factories\CeoFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Ceo
 *
 * @property int $id
 * @property string $fname
 * @property string $lname
 * @property int $gender
 * @property string $dob
 * @property string $dept_id
 * @property string|null $avatar
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
 * @property-read Department|null $department
 * @property-read Role|null $role
 */
class Ceo extends Model
{
    use HasFactory, SoftDeletes;

	protected $fillable = [
		'fname',
		'lname',
		'gender',
        'avatar',
        'phone',
		'dob',
        'city',
        'district',
		'email',
		'password',
	];

    public function getAgeAttribute(): string
	{
		return date_diff(date_create($this->dob), date_create())->y;
	}

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

	public $timestamps = true;
}
