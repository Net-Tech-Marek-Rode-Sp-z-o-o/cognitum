<?php

declare(strict_types=1);

namespace Tests\ObjectMothers\Duties;

use Modules\Duties\Domain\Enums\DutyTypeEnum;
use Modules\Duties\Infrastructure\Parsers\DTR\DTRParser;
use Modules\Duties\Infrastructure\Parsers\ParserRegistry;
use Tests\Mocks\MockTranslator;

class ParserRegistryFactory
{
    public static function new(): ParserRegistry
    {
        return new ParserRegistry(translator: new MockTranslator(), drivers: [
            DutyTypeEnum::DTR->value => new DTRParser(),
        ]);
    }
}
