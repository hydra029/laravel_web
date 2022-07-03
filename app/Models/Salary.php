<?php

namespace App\Models;

use Database\Factories\SalaryFactory;
use Illuminate\Database\Eloquent\Builder;
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
 */
class Salary extends Model
{
    use HasFactory;
	public $timestamps = false;

	public function emp(): HasMany
	{
		return $this->hasMany(Employee::class, 'emp_id');
	}
	public function mgr(): HasMany
	{
		return $this->hasMany(Manager::class, 'mgr_id');
	}
	public function acct(): HasMany
	{
		return $this->hasMany(Accountant::class, 'acct_id');
	}
	public function pay_rate(): HasMany
	{
		return $this->hasMany(Role::class, 'pay_rate');
	}

}
