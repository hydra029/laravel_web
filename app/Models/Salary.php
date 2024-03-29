<?php
/** @noinspection NullPointerExceptionInspection */

namespace App\Models;

use Database\Factories\SalaryFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Thiagoprz\CompositeKey\HasCompositeKey;

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
 * @mixin Eloquent
 * @property-read Collection|Accountant[] $acct
 * @property-read int|null $acct_count
 * @property-read Collection|Employee[] $emp
 * @property-read int|null $emp_count
 * @property-read Collection|Manager[] $mgr
 * @property-read int|null $mgr_count
 * @property-read int|null $pay_rate_count
 * @property float $over_work_day
 * @property float $off_work_day
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
 * @method static Builder|Salary whereOffWorkDay($value)
 * @method static Builder|Salary whereSign($value)
 * @method static Builder|Salary whereUpdatedAt($value)
 * @property-read string $bonus_salary_off_work_day
 * @property-read string $bonus_salary_over_work_day
 * @property-read string $bonus_salary_total_off_work_day
 * @property-read string $deduction_detail
 * @property-read string $deduction_early_one_detail
 * @property-read string $deduction_early_two_detail
 * @property-read string $deduction_late_one_detail
 * @property-read string $deduction_late_two_detail
 * @property-read string $deduction_miss_detail
 * @property-read string $pay_rate_money
 * @property-read string $pay_rate_off_work_day
 * @property-read string $pay_rate_over_work_day
 * @property-read string $pay_rate_work_day
 * @property-read string $salary_money
 */
class Salary extends Model
{
	use HasFactory, HasCompositeKey;

	public    $timestamps = false;
	protected $guarded    = [];
	protected $primaryKey = [
		'emp_id',
		'month',
		'year',
		'dept_name',
		'role_name',
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

	public function getSalaryMoneyAttribute(): string
	{
		return number_format((float)($this->salary)) . ' VNĐ';
	}

	public function getPayRateMoneyAttribute(): string
	{
		return number_format((float)($this->pay_rate)) . ' VNĐ';
	}

	public function getDeductionDetailAttribute(): string
	{
		return '-' . number_format((float)($this->deduction)) . ' VNĐ';
	}

	public function getDeductionLateOneDetailAttribute(): string
	{
		$deduction = Fines::select('deduction')->whereId(1)->first();
		return '-' . number_format((float)($this->late_1 * $deduction['deduction'])) . ' VNĐ';
	}

	public function getDeductionLateTwoDetailAttribute(): string
	{
		$deduction = Fines::select('deduction')->whereId(2)->first();
		return '-' . number_format((float)($this->late_2 * $deduction['deduction'])) . ' VNĐ';
	}

	public function getDeductionEarlyOneDetailAttribute(): string
	{
		$deduction = Fines::select('deduction')->whereId(3)->first();
		return '-' . number_format((float)($this->early_1 * $deduction['deduction'])) . ' VNĐ';
	}

	public function getDeductionEarlyTwoDetailAttribute(): string
	{
		$deduction = Fines::select('deduction')->whereId(4)->first();
		return '-' . number_format((float)($this->early_2 * $deduction['deduction'])) . ' VNĐ';
	}

	public function getDeductionMissDetailAttribute(): string
	{
		$deduction = Fines::select('deduction')->whereId(5)->first();
		return '-' . number_format((float)($this->miss * $deduction['deduction'])) . ' VNĐ';
	}

	public function getBonusSalaryOverWorkDayAttribute(): string
	{
		$salary_over_day = ($this->pay_rate / 26) * 1.5;
		return number_format($salary_over_day * $this->over_work_day) . ' VNĐ';
	}

	public function getPayRateOverWorkDayAttribute(): string
	{
		return number_format(($this->pay_rate / 26) * 1.5) . ' VNĐ';
	}

	public function getPayRateWorkDayAttribute(): string
	{
		return number_format((float)($this->pay_rate / 26)) . ' VNĐ';
	}

	public function getBonusSalaryOffWorkDayAttribute(): string
	{
		$salary_off_day = ($this->pay_rate / 26) * 2;
		return number_format($salary_off_day * $this->off_work_day) . ' VNĐ';
	}

	public function getBonusSalaryTotalOffWorkDayAttribute(): string
	{
		$salary_over_day = ($this->pay_rate / 26) * 2 * $this->off_work_day + ($this->pay_rate / 26) * 1.5 * $this->over_work_day;
		return number_format($salary_over_day) . ' VNĐ';
	}

	public function getPayRateOffWorkDayAttribute(): string
	{
		return number_format(($this->pay_rate / 26) * 2) . ' VNĐ';
	}
}
