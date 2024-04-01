<?php

declare(strict_types=1);

namespace Tests\Unit\Duties\ValueObjects;

use Carbon\Carbon;
use Modules\Duties\Domain\ValueObject\DutyPeriod;
use PHPUnit\Framework\TestCase;

final class DutyPeriodTest extends TestCase
{
    public function testFailingToCreate(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new DutyPeriod(
            departure: Carbon::parse('2021-01-01 19:00:00'),
            arrival: Carbon::parse('2021-01-01 16:00:00'),
        );
    }
}
