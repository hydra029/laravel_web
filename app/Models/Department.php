<?php

namespace App\Models;

use Database\Factories\DepartmentFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Department
 *
 * @property int $id
 * @property string $name
 * @property int $status
 * @method static DepartmentFactory factory(...$parameters)
 * @method static Builder|Department newModelQuery()
 * @method static Builder|Department newQuery()
 * @method static Builder|Department query()
 * @method static Builder|Department whereId($value)
 * @method static Builder|Department whereName($value)
 * @method static Builder|Department whereStatus($value)
 * @mixin \Eloquent
 * @property-read Manager|null $manager
 * @property-read Employee|null $members
 * @property-read Role|null $roles
 */
class Department extends Model
{
    use HasFactory, SoftDeletes;
	public $timestamps = false;

    protected $fillable = [
        'name',
    ];


    public function manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class, 'id','dept_id');
    }

    public function members(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'id','dept_id');
    }

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class, 'dept_id');
    }

}
