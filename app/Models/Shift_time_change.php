<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Shift_time_change
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Shift_time_change newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shift_time_change newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shift_time_change query()
 * @method static \Illuminate\Database\Eloquent\Builder|Shift_time_change whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shift_time_change whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shift_time_change whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Shift_time_change extends Model
{
    use HasFactory;
}
