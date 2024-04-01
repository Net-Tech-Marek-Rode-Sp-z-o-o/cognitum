<?php

declare(strict_types=1);

namespace Tests\Unit\Duties\ValueObjects;

use Carbon\Carbon;
use Modules\Duties\Domain\ValueObject\DutyCheck;
use PHPUnit\Framework\TestCase;

final class DutyCheckTest extends TestCase
{
    public function testFailingToCreate(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new DutyCheck(
            in: Carbon::parse('2021-01-01 19:00:00'),
            out: Carbon::parse('2021-01-01 16:00:00'),
        );
    }
}
