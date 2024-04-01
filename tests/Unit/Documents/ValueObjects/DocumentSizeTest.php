<?php

declare(strict_types=1);

namespace Tests\Unit\Documents\ValueObjects;

use Illuminate\Foundation\Testing\WithFaker;
use Modules\Documents\Domain\ValueObjects\DocumentSize;
use PHPUnit\Framework\TestCase;

final class DocumentSizeTest extends TestCase
{
    use WithFaker;

    private int $size;

    private DocumentSize $vo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setupFaker();

        $this->vo = new DocumentSize(
            $this->size = $this->faker->randomNumber()
        );
    }

    public function testConvertingToIntValueObject(): void
    {
        $this->assertEquals($this->size, $this->vo->toInt());
    }
}
