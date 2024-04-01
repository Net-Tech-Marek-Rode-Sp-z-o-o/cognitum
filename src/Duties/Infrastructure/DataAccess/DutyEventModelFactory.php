<?php

declare(strict_types=1);

namespace Modules\Duties\Infrastructure\DataAccess;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Duties\Domain\Enums\DutyEventEnum;

/**
 * @extends Factory<DutyEventModel>
 */
final class DutyEventModelFactory extends Factory
{
    protected $model = DutyEventModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /** @var DutyEventEnum $type */
        $type = $this->faker->randomElement(DutyEventEnum::cases());

        return [
            'id' => $this->faker->uuid(),
            'type' => $type->value,
        ];
    }
}
