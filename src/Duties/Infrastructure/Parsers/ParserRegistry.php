<?php

declare(strict_types=1);

namespace Modules\Duties\Infrastructure\Parsers;

use Illuminate\Contracts\Translation\Translator;
use Modules\Duties\Domain\Enums\DutyTypeEnum;
use Modules\Duties\Domain\Exceptions\DutyImportFailedException;

final readonly class ParserRegistry
{
    /**
     * @param  ParserInterface[]  $drivers
     */
    public function __construct(
        private Translator $translator,
        private array $drivers = [],
    ) {
    }

    public function get(DutyTypeEnum $type): ParserInterface
    {
        return $this->drivers[$type->value] ?: throw $this->newDutyImportFailedException();
    }

    private function newDutyImportFailedException(): DutyImportFailedException
    {
        return new DutyImportFailedException(
            message: $this->translator->get('duties::exceptions.import_failed')
        );
    }
}
