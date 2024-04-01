<?php

declare(strict_types=1);

namespace Tests\ObjectMothers\Duties;

use Carbon\Carbon;
use Modules\Duties\Domain\Duty;
use Modules\Duties\Domain\Enums\DutyEventEnum;
use Modules\Duties\Domain\Enums\DutyTypeEnum;
use Modules\Duties\Domain\ValueObject as VO;

final readonly class DutyFactory
{
    public static function fake(): Duty
    {
        return new Duty(
            id: VO\DutyId::getNew(),
            date: new VO\DutyDate(Carbon::parse('2021-01-01')),
            check: new VO\DutyCheck(
                in: Carbon::parse('2021-01-01 08:00:00'),
                out: Carbon::parse('2021-01-01 16:00:00'),
            ),
            type: DutyTypeEnum::DTR,
            flight: new VO\DutyFlight(flight: 'DX1234'),
            location: new VO\DutyLocation(from: 'A', to: 'B'),
            period: new VO\DutyPeriod(
                departure: Carbon::parse('2021-01-01 06:00:00'),
                arrival: Carbon::parse('2021-01-01 22:00:00'),
            ),
            events: [DutyEventEnum::CI, DutyEventEnum::CO],
        );
    }
}
