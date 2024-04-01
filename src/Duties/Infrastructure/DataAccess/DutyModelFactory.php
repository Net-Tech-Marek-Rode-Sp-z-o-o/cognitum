<?php

declare(strict_types=1);

namespace Modules\Duties\Infrastructure\DataAccess;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Duties\Domain\Enums\DutyTypeEnum;

/**
 * @extends Factory<DutyModel>
 */
final class DutyModelFactory extends Factory
{
    protected $model = DutyModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'type' => DutyTypeEnum::DTR->value,
            'date' => $date = Carbon::parse($this->faker->date()),
            'check_in' => $date->clone()->setTime(7, 0),
            'check_out' => $date->clone()->setTime(18, 0),
            'flight' => Str::random(4),
            'departure_at' => $date->clone()->setTime(8, 0),
            'arrival_at' => $date->clone()->setTime(17, 0),
            'duration' => 9,
            'from' => 'JFK',
            'to' => 'LAX',
        ];
    }

    public function configure(): self
    {
        return $this->afterCreating(fn (DutyModel $duty) => DutyEventModel::factory(random_int(1, 3))->create([
            'duty_id' => $duty->id,
        ]));
    }
}
