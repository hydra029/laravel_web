<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 * @method static \Database\Factories\SalaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Salary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Salary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Salary query()
 * @method static \Illuminate\Database\Eloquent\Builder|Salary whereAcctId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salary whereCeoSign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salary whereDeptName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salary whereEmpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salary whereMgrId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salary whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salary wherePayRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salary whereRoleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salary whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salary whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salary whereWorkDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salary whereYear($value)
 * @mixin \Eloquent
 */
class Salary extends Model
{
    use HasFactory;
	public $timestamps = false;

}
