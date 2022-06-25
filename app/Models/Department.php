<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Department
 *
 * @property int $id
 * @property string $name
 * @property int $status
 * @method static \Database\Factories\DepartmentFactory factory(...$parameters)
 * @method static Builder|Department newModelQuery()
 * @method static Builder|Department newQuery()
 * @method static Builder|Department query()
 * @method static Builder|Department whereId($value)
 * @method static Builder|Department whereName($value)
 * @method static Builder|Department whereStatus($value)
 * @mixin \Eloquent
 */
class Department extends Model
{
    use HasFactory;
	public $timestamps = false;

    protected $fillable = [
        'name',
        'status',
    ];

    protected $status = [
        'status' => 'integer',
    ];

}
