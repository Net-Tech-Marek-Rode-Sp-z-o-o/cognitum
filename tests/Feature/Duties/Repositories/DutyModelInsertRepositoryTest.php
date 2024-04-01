<?php

declare(strict_types=1);

namespace Tests\Feature\Duties\Repositories;

use Modules\Duties\Infrastructure\Repositories\DutyModelInsertRepository;
use Tests\ObjectMothers\Duties\DutyFactory;
use Tests\TestCase;

final class DutyModelInsertRepositoryTest extends TestCase
{
    private DutyModelInsertRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->app->make(DutyModelInsertRepository::class);
    }

    public function testSavingDuty(): void
    {
        $this->repository->save($duty = DutyFactory::fake());

        $this->assertDatabaseHas('duties', [
            'id' => $duty->getId()->toString(),
            'type' => $duty->getType()->value,
            'check_in' => $duty->getCheck()->in?->toDateTimeString(),
            'check_out' => $duty->getCheck()->out?->toDateTimeString(),
            'flight' => $duty->getFlight()->raw(),
            'departure_at' => $duty->getPeriod()->departure->toDateTimeString(),
            'arrival_at' => $duty->getPeriod()->arrival->toDateTimeString(),
            'duration' => $duty->getPeriod()->toInt(),
            'from' => $duty->getLocation()->from,
            'to' => $duty->getLocation()->to,
        ]);

        $this->assertDatabaseCount('duties_events', count($duty->getEvents()));
    }
}
