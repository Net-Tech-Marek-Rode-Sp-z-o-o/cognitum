<?php

declare(strict_types=1);

namespace Modules\Duties\Infrastructure\DataAccess;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Modules\Duties\Domain\Enums\DutyEventEnum;

/**
 * @mixin Builder
 *
 * @method static Builder|static query()
 * @method Builder|static newQuery()
 * @method static static make(array $attributes = [])
 * @method static static create(array $attributes = [])
 * @method static static forceCreate(array $attributes)
 * @method static firstOrNew(array $attributes = [], array $values = [])
 * @method static firstOrFail(array $columns = ['*'])
 * @method static firstOrCreate(array $attributes, array $values = [])
 * @method static firstOr(array|Closure $columns = ['*'], Closure $callback = null)
 * @method static firstWhere(string $column, string $operator = null, mixed $value = null, string $boolean = 'and')
 * @method static updateOrCreate(array $attributes, array $values = [])
 * @method null|static first(array $columns = ['*'])
 * @method static static findOrFail(mixed $id, array $columns = ['*'])
 * @method static static findOrNew(mixed $id, array $columns = ['*'])
 * @method static null|static find(mixed $id, array $columns = ['*'])
 *
 * @property string $id
 * @property string $duty_id
 * @property DutyEventEnum $type
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read DutyModel $duty
 */
final class DutyEventModel extends Model
{
    use HasFactory;

    protected $table = 'duties_events';

    public $incrementing = false;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'type' => DutyEventEnum::class,
    ];

    protected $fillable = [
        'id',
        'duty_id',
        'type',
        'created_at',
        'updated_at',
    ];

    protected static function newFactory(): Factory
    {
        return DutyEventModelFactory::new();
    }

    public function duty(): HasOne
    {
        return $this->hasOne(DutyModel::class, 'id', 'duty_id');
    }
}
