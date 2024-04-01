<?php

declare(strict_types=1);

namespace Tests\Unit\Documents\ValueObjects;

use Illuminate\Foundation\Testing\WithFaker;
use Modules\Documents\Domain\ValueObjects\DocumentOriginalName;
use PHPUnit\Framework\TestCase;

final class DocumentOriginalNameTest extends TestCase
{
    use WithFaker;

    private string $name;

    private DocumentOriginalName $vo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setupFaker();

        $this->vo = new DocumentOriginalName(
            $this->name = $this->faker->name(),
        );
    }

    public function testStringifyValueObject(): void
    {
        $this->assertEquals($this->name, $this->vo->toString());
        $this->assertEquals($this->name, $this->vo->__toString());
    }
}
