<?php

declare(strict_types=1);

namespace Tests\Unit\Documents\ValueObjects;

use Illuminate\Foundation\Testing\WithFaker;
use Modules\Documents\Domain\ValueObjects\DocumentPath;
use PHPUnit\Framework\TestCase;

final class DocumentPathTest extends TestCase
{
    use WithFaker;

    private string $path;

    private DocumentPath $vo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setupFaker();

        $this->vo = new DocumentPath(
            $this->path = $this->faker->filePath(),
        );
    }

    public function testStringifyValueObject(): void
    {
        $this->assertEquals($this->path, $this->vo->toString());
        $this->assertEquals($this->path, $this->vo->__toString());
    }
}
