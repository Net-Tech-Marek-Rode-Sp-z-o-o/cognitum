<?php

declare(strict_types=1);

namespace Modules\Duties\Infrastructure\Parsers;

use Modules\Duties\Domain\Duty;
use Modules\Duties\Domain\Enums\DutyTypeEnum;

interface ParserInterface
{
    /**
     * @return Duty[]
     */
    public function handle(string $content): array;

    public function type(): DutyTypeEnum;
}
