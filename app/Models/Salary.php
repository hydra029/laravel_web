<?php

namespace App\Models;

use Database\Factories\SalaryFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Salary
 *
 * @property int $emp_id
 * @property int $month
 * @property int $year
 * @property string $dept_name
 * @property string $role_name
 * @property int $work_day
 * @property int $pay_rate
 * @property int $salary
 * @property int $mgr_id
 * @property int $acct_id
 * @property int $ceo_sign
 * @property int $status
 * @method static SalaryFactory factory(...$parameters)
 * @method static Builder|Salary newModelQuery()
 * @method static Builder|Salary newQuery()
 * @method static Builder|Salary query()
 * @method static Builder|Salary whereAcctId($value)
 * @method static Builder|Salary whereCeoSign($value)
 * @method static Builder|Salary whereDeptName($value)
 * @method static Builder|Salary whereEmpId($value)
 * @method static Builder|Salary whereMgrId($value)
 * @method static Builder|Salary whereMonth($value)
 * @method static Builder|Salary wherePayRate($value)
 * @method static Builder|Salary whereRoleName($value)
 * @method static Builder|Salary whereSalary($value)
 * @method static Builder|Salary whereStatus($value)
 * @method static Builder|Salary whereWorkDay($value)
 * @method static Builder|Salary whereYear($value)
 * @mixin \Eloquent
 * @property-read Collection|Accountant[] $acct
 * @property-read int|null $acct_count
 * @property-read Collection|Employee[] $emp
 * @property-read int|null $emp_count
 * @property-read Collection|Manager[] $mgr
 * @property-read int|null $mgr_count
 * @property-read int|null $pay_rate_count
 * @property float $over_work_day
 * @property int $late_1
 * @property int $late_2
 * @property int $early_1
 * @property int $early_2
 * @property int $miss
 * @property int $deduction
 * @property int|null $sign
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static Builder|Salary whereCreatedAt($value)
 * @method static Builder|Salary whereDeduction($value)
 * @method static Builder|Salary whereEarly1($value)
 * @method static Builder|Salary whereEarly2($value)
 * @method static Builder|Salary whereLate1($value)
 * @method static Builder|Salary whereLate2($value)
 * @method static Builder|Salary whereMiss($value)
 * @method static Builder|Salary whereOverWorkDay($value)
 * @method static Builder|Salary whereSign($value)
 * @method static Builder|Salary whereUpdatedAt($value)
 */
class Salary extends Model
{
	use HasFactory;

	public    $timestamps = false;
	protected $fillable   = [
		'emp_id',
		'role_name',
		'dept_name',
		'role_id',
		'work_day',
		'over_work_day',
		'miss',
		'early_1',
		'early_2',
		'late_1',
		'late_2',
		'month',
		'year',
		'deduction',
		'pay_rate',
		'salary',
		'mgr_id',
		'acct_id',
		'sign',
	];

	public function emp(): HasMany
	{
		return $this->hasMany(Employee::class, 'id', 'emp_id');
	}

	public function mgr(): HasMany
	{
		return $this->hasMany(Manager::class, 'mgr_id');
	}

	public function acct(): HasMany
	{
		return $this->hasMany(Accountant::class, 'acct_id');
	}
	public function getSalaryMoneyAttribute()
	{
		return number_format((float)($this->salary)). ' đ' ;
	}
	public function getPayRateMoneyAttribute()
	{
		return number_format((float)($this->pay_rate)). ' đ' ;
	}
	public function getDeductionDetailAttribute()
    {
        return '-' . number_format((float)($this->deduction)). ' đ';
    }

}
