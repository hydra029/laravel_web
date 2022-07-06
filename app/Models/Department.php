<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property-read \App\Models\Manager|null $manager
 * @property-read \App\Models\Employee|null $members
 * @property-read \App\Models\Role|null $roles
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

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class, 'id','dept_id');
    }

    public function members(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'id','dept_id');
    }

    public function roles(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'id','dept_id');
    }

}
