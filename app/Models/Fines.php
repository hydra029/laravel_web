<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Fines
 *
 * @property int $id
 * @property string $name
 * @property integer $fines
 * @property float $deduction
 * @method static Builder|Fines newModelQuery()
 * @method static Builder|Fines newQuery()
 * @method static Builder|Fines Query()
 * @mixin Eloquent
 *
 * @property-read string $fines_time
 *
 */

class Fines extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'fines',
        'deduction',
    ];


    public function getFinesTimeAttribute($fines)
    {
        return "{$this->fines} phút" ;
    }

    public function getDeductionDetailAttribute()
    {
        return '-' . ($this->deduction) * 100 . '%';
    }
}