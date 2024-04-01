<?php

declare(strict_types=1);

namespace Tests\Unit\Duties\ValueObjects;

use Illuminate\Foundation\Testing\WithFaker;
use Modules\Duties\Domain\ValueObject\DutyId;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class DutyIdTest extends TestCase
{
    use WithFaker;

    private UuidInterface $id;

    private DutyId $vo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setupFaker();

        $this->vo = new DutyId(
            $this->id = Uuid::uuid4(),
        );
    }

    public function testStringifyValueObject(): void
    {
        $this->assertEquals($this->id->toString(), $this->vo->toString());
        $this->assertEquals($this->id->toString(), $this->vo->__toString());
    }
}
