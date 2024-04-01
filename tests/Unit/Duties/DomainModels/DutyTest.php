<?php

declare(strict_types=1);

namespace Tests\Unit\Duties\DomainModels;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Duties\Domain\Duty;
use Modules\Duties\Domain\Enums\DutyEventEnum;
use Modules\Duties\Domain\Enums\DutyTypeEnum;
use Modules\Duties\Domain\ValueObject as VO;
use PHPUnit\Framework\TestCase;

final class DutyTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setupFaker();
    }

    public function testCreatingNewDuty(): void
    {
        $duty = new Duty(
            id: $id = VO\DutyId::getNew(),
            date: $date = new VO\DutyDate(Carbon::parse('2021-01-01')),
            check: $check = new VO\DutyCheck(
                in: Carbon::parse('2021-01-01 08:00:00'),
                out: Carbon::parse('2021-01-01 16:00:00'),
            ),
            type: $type = DutyTypeEnum::DTR,
            flight: $flight = new VO\DutyFlight(flight: 'DX1234'),
            location: $location = new VO\DutyLocation(from: 'A', to: 'B'),
            period: $period = new VO\DutyPeriod(
                departure: Carbon::parse('2021-01-01 06:00:00'),
                arrival: Carbon::parse('2021-01-01 22:00:00'),
            ),
            events: $events = [DutyEventEnum::CI, DutyEventEnum::CO],
        );

        $this->assertEquals($id->toString(), $duty->getId()->toString());
        $this->assertEquals($date->toString(), $duty->getDate()->toString());
        $this->assertEquals($check, $duty->getCheck());
        $this->assertEquals($type, $duty->getType());
        $this->assertEquals($flight, $duty->getFlight());
        $this->assertEquals($location, $duty->getLocation());
        $this->assertEquals($period, $duty->getPeriod());
        $this->assertEquals($events, $duty->getEvents());
    }
}
