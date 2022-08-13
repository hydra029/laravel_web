<?php

namespace App\Models;

use Database\Factories\FinesFactory;
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
 * @property-read string $fines_time
 * @property-read mixed $deduction_detail
 * @property-read mixed $fines_id
 * @method static FinesFactory factory(...$parameters)
 * @method static Builder|Fines whereDeduction($value)
 * @method static Builder|Fines whereFines($value)
 * @method static Builder|Fines whereId($value)
 * @method static Builder|Fines whereName($value)
 * @property string $type
 * @method static Builder|Fines query()
 * @method static Builder|Fines whereType($value)
 */

class Fines extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'fines',
        'deduction',
    ];
    public function getFinesIdAttribute()
    {
        return $this->id . '.';
    }

    public function getFinesTimeAttribute($fines)
    {
        return "{$this->fines} phút" ;
    }

    public function getDeductionDetailAttribute()
    {
        return '-' . number_format((float)($this->deduction)). ' đ';
    }
}
