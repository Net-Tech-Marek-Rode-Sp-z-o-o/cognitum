<?php

declare(strict_types=1);

namespace Tests\Unit\Documents\ValueObjects;

use Illuminate\Foundation\Testing\WithFaker;
use Modules\Documents\Domain\ValueObjects\DocumentMime;
use PHPUnit\Framework\TestCase;

final class DocumentMimeTest extends TestCase
{
    use WithFaker;

    private string $mime;

    private DocumentMime $vo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setupFaker();

        $this->vo = new DocumentMime(
            $this->mime = $this->faker->mimeType(),
        );
    }

    public function testStringifyValueObject(): void
    {
        $this->assertEquals($this->mime, $this->vo->toString());
        $this->assertEquals($this->mime, $this->vo->__toString());
    }
}
