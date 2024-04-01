<?php

declare(strict_types=1);

namespace Tests\Feature\Duties\Http\Controllers;

use Modules\Duties\Infrastructure\DataAccess\DutyEventModel;
use Modules\Duties\Infrastructure\DataAccess\DutyModelFactory;
use Tests\TestCase;

final class DutyEventsControllerTest extends TestCase
{
    public function testListingDutyEvents(): void
    {
        DutyModelFactory::new()->createMany(10);

        $response = $this->getJson(route('duties.events'));

        $response->assertOk();
        $response->assertJsonStructure([
            'events' => [
                '*' => [
                    'id',
                    'date',
                    'from',
                    'to',
                    'type',
                    'check_in',
                    'check_out',
                    'departure',
                    'arrival',
                ],
            ],
        ]);
        $response->assertJsonCount(DutyEventModel::query()->count(), 'events');
    }

    public function testFilteringDutyEventsByLocation(): void
    {
        DutyModelFactory::new()->create([
            'from' => 'DUB', // decoy
        ]);
        $duty = DutyModelFactory::new()->create($filters = [
            'from' => 'MAD',
        ]);

        $response = $this->getJson(route('duties.events', [
            'filters' => $filters,
        ]));

        $response->assertOk();
        $response->assertJsonStructure([
            'events' => [
                '*' => [
                    'id',
                    'date',
                    'from',
                    'to',
                    'type',
                    'check_in',
                    'check_out',
                    'departure',
                    'arrival',
                ],
            ],
        ]);
        $response->assertJsonCount($duty->events()->count(), 'events');
    }

    public function testFilteringDutyEventsByDate(): void
    {
        DutyModelFactory::new()->create([
            'date' => '2022-10-01', // decoy
        ]);
        $duty = DutyModelFactory::new()->create([
            'date' => '2022-10-02',
        ]);

        $response = $this->getJson(route('duties.events', [
            'filters' => [
                'date' => [
                    '2022-10-02',
                    '2022-10-03',
                ],
            ],
        ]));

        $response->assertOk();
        $response->assertJsonStructure([
            'events' => [
                '*' => [
                    'id',
                    'date',
                    'from',
                    'to',
                    'type',
                    'check_in',
                    'check_out',
                    'departure',
                    'arrival',
                ],
            ],
        ]);
        $response->assertJsonCount($duty->events()->count(), 'events');
    }

    public function testFilteringDutyEventsByType(): void
    {
        $duty = DutyModelFactory::new()->create();

        $response = $this->getJson(route('duties.events', [
            'filters' => [
                'types' => [
                    $type = $duty->events()->first()->type->value,
                ],
            ],
        ]));

        $response->assertOk();
        $response->assertJsonStructure([
            'events' => [
                '*' => [
                    'id',
                    'date',
                    'from',
                    'to',
                    'type',
                    'check_in',
                    'check_out',
                    'departure',
                    'arrival',
                ],
            ],
        ]);
        $response->assertJsonCount($duty->events()->where('type', $type)->count(), 'events');
    }
}
