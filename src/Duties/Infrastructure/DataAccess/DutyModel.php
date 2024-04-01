<?php

declare(strict_types=1);

namespace Modules\Duties\Infrastructure\DataAccess;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Modules\Duties\Domain\Enums\DutyTypeEnum;

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
 * @property DutyTypeEnum $type
 * @property Carbon $date
 * @property Carbon|null $check_in
 * @property Carbon|null $check_out
 * @property string|null $flight
 * @property Carbon|null $departure_at
 * @property Carbon|null $arrival_at
 * @property int $duration
 * @property string|null $from
 * @property string|null $to
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Collection<DutyEventModel> $events
 */
final class DutyModel extends Model
{
    use HasFactory;

    protected $table = 'duties';

    public $incrementing = false;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'type' => DutyTypeEnum::class,
        'departure_at' => 'datetime',
        'arrival_at' => 'datetime',
        'duration' => 'int',
    ];

    protected static function newFactory(): Factory
    {
        return DutyModelFactory::new();
    }

    public function events(): HasMany
    {
        return $this->hasMany(DutyEventModel::class, 'duty_id', 'id');
    }
}
