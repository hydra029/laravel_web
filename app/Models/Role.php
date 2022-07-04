<?php

namespace App\Models;

use Database\Factories\RoleFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property int $status
 * @method static RoleFactory factory(...$parameters)
 * @method static Builder|Role newModelQuery()
 * @method static Builder|Role newQuery()
 * @method static Builder|Role query()
 * @method static Builder|Role whereId($value)
 * @method static Builder|Role whereName($value)
 * @method static Builder|Role whereStatus($value)
 * @mixin \Eloquent
 */
class Role extends Model
{
    use HasFactory;
	public $timestamps = false;

   protected $fillable = [
       'name',
       'dept_id',
       'pay_rate',
       'status',
   ];

   public function getPayRateMoneyAttribute(): string
   {
        return number_format((float)($this->pay_rate)) . ' đ';
   }

}
