<?php

namespace App\Models;

use Database\Factories\RoleFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property int $dept_id
 * @property int $pay_rate
 * @property-read string $pay_rate_money
 * @method static Builder|Role whereDeptId($value)
 * @method static Builder|Role wherePayRate($value)
 * @property string|null $deleted_at
 * @property-read \App\Models\Department $departments
 * @method static Builder|Role whereDeletedAt($value)
 */
class Role extends Model
{
    use HasFactory;
	public $timestamps = false;

   protected $fillable = [
        'id',
       'name',
       'dept_id',
       'pay_rate',
       'status',
   ];

   public function getPayRateMoneyAttribute()
   {
        return number_format((float)($this->pay_rate)) . ' đ';
   }

	public function departments(): BelongsTo
	{
		return $this->BelongsTo(Department::class, 'dept_id', 'id')
			->select(['id', 'name']);

	}

}
