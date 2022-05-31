<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 * @method static \Database\Factories\CeoFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Ceo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ceo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ceo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ceo whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ceo whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ceo whereFname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ceo whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ceo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ceo whereLname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ceo wherePassword($value)
 * @mixin \Eloquent
 */
class Ceo extends Model
{
    use HasFactory;
	public $timestamps = false;
}
