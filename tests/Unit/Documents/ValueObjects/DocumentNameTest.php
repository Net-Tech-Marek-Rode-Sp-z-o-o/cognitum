<?php

declare(strict_types=1);

namespace Tests\Unit\Documents\ValueObjects;

use Illuminate\Foundation\Testing\WithFaker;
use Modules\Documents\Domain\ValueObjects\DocumentName;
use PHPUnit\Framework\TestCase;

final class DocumentNameTest extends TestCase
{
    use WithFaker;

    private string $name;

    private DocumentName $vo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setupFaker();

        $this->vo = new DocumentName(
            $this->name = $this->faker->name(),
        );
    }

    public function testStringifyValueObject(): void
    {
        $this->assertEquals($this->name, $this->vo->toString());
        $this->assertEquals($this->name, $this->vo->__toString());
    }
}
