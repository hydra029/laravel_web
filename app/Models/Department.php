<?php

namespace App\Models;

use Database\Factories\DepartmentFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

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
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read int|null $members_count
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Query\Builder|Department onlyTrashed()
 * @method static Builder|Department whereCreatedAt($value)
 * @method static Builder|Department whereDeletedAt($value)
 * @method static Builder|Department whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Department withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Department withoutTrashed()
 * @property int|null $acct_id
 * @property-read Collection|Accountant[] $acctmembers
 * @property-read int|null $acctmembers_count
 * @property-read string $acct
 * @property-read string $acct_name
 * @method static Builder|Department whereAcctId($value)
 */
class Department extends Model
{
    use HasFactory, SoftDeletes;
	public $timestamps = false;

    protected $fillable = [
        'name',
    ];

	public function getAcctAttribute(): string
	{
		$acc = Accountant::where('id','=', $this->acct_id)->first(['fname','lname']);
		return $acc ? $acc['fname'] . ' ' . $acc['lname']: 'unassigned';
	}

	public function getAcctNameAttribute(): string
	{
		return $this->acct_id ?? 0;
	}

    public function manager(): HasOne
    {
        return $this->hasOne(Manager::class, 'dept_id');
    }

    public function members(): hasMany
    {
        return $this->hasMany(Employee::class, 'dept_id');
    }

    public function acctmembers(): hasMany
    {
        return $this->hasMany(Accountant::class, 'dept_id');
    }

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class, 'dept_id');
    }

}
