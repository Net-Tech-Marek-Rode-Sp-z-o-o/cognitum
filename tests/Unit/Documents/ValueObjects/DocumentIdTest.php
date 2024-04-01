<?php

declare(strict_types=1);

namespace Tests\Unit\Documents\ValueObjects;

use Illuminate\Foundation\Testing\WithFaker;
use Modules\Documents\Domain\ValueObjects\DocumentId;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class DocumentIdTest extends TestCase
{
    use WithFaker;

    private UuidInterface $id;

    private DocumentId $vo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setupFaker();

        $this->vo = new DocumentId(
            $this->id = Uuid::uuid4(),
        );
    }

    public function testStringifyValueObject(): void
    {
        $this->assertEquals($this->id->toString(), $this->vo->toString());
        $this->assertEquals($this->id->toString(), $this->vo->__toString());
    }
}
