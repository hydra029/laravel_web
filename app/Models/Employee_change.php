<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Employee_change
 *
 * @property int $id
 * @property int $emp_id
 * @property string $dept_name
 * @property string $role_name
 * @property Carbon $updated_at
 * @method static Builder|Employee_change newModelQuery()
 * @method static Builder|Employee_change newQuery()
 * @method static Builder|Employee_change query()
 * @method static Builder|Employee_change whereDeptName($value)
 * @method static Builder|Employee_change whereEmpId($value)
 * @method static Builder|Employee_change whereId($value)
 * @method static Builder|Employee_change whereRoleName($value)
 * @method static Builder|Employee_change whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Employee_change extends Model
{
    use HasFactory;
}
