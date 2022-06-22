<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Shift_time_change
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Shift_time_change newModelQuery()
 * @method static Builder|Shift_time_change newQuery()
 * @method static Builder|Shift_time_change query()
 * @method static Builder|Shift_time_change whereCreatedAt($value)
 * @method static Builder|Shift_time_change whereId($value)
 * @method static Builder|Shift_time_change whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Shift_time_change extends Model
{
    use HasFactory;
}
