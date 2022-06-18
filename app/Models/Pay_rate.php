<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Pay_rate
 *
 * @property int $dept_id
 * @property int $role_id
 * @property int $pay_rate
 * @method static \Database\Factories\Pay_rateFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Pay_rate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pay_rate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pay_rate query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pay_rate whereDeptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pay_rate wherePayRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pay_rate whereRoleId($value)
 * @mixin \Eloquent
 */
class Pay_rate extends Model
{
    use HasFactory;
	public $timestamps = false;

    protected $fillable = [
        'dept_id',
        'role_id',
        'pay_rate',
    ];
    
    protected $pay_rate = [
        'pay_rate' => 'integer',
    ];

    public function getPayRateMoneyAttribute(): string
    {   
        return number_format((float)($this->pay_rate)) . ' đ';
    }
}
