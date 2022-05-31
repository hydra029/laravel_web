<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Pay_rate_change
 *
 * @property int $id
 * @property string $dept_name
 * @property string $role_name
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Pay_rate_change newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pay_rate_change newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pay_rate_change query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pay_rate_change whereDeptName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pay_rate_change whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pay_rate_change whereRoleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pay_rate_change whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Pay_rate_change extends Model
{
    use HasFactory;
}
