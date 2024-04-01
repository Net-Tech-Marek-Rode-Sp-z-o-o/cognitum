<?php

declare(strict_types=1);

namespace Tests\Unit\Duties\Parsers;

use Modules\Duties\Infrastructure\Parsers\DTR\DTRParser;
use PHPUnit\Framework\TestCase;

final class DTRParserTest extends TestCase
{
    public function testParsingFile(): void
    {
        $parser = new DTRParser();
        $content = file_get_contents(__DIR__.'/../../../fixtures/dtr.html');
        $duties = $parser->handle($content);

        $this->assertNotEmpty($duties);
    }
}
