<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Pay_rate_change
 *
 * @property int $id
 * @property string $dept_name
 * @property string $role_name
 * @property Carbon $updated_at
 * @method static Builder|Pay_rate_change newModelQuery()
 * @method static Builder|Pay_rate_change newQuery()
 * @method static Builder|Pay_rate_change query()
 * @method static Builder|Pay_rate_change whereDeptName($value)
 * @method static Builder|Pay_rate_change whereId($value)
 * @method static Builder|Pay_rate_change whereRoleName($value)
 * @method static Builder|Pay_rate_change whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Pay_rate_change extends Model
{
    use HasFactory;
}
