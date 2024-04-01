<?php

declare(strict_types=1);

namespace Tests\Mocks\Duties;

use Modules\Duties\Domain\Duty;
use Modules\Duties\Domain\Repositories\DutyInsertRepositoryInterface;

final class MockDutyInMemoryInsertRepository implements DutyInsertRepositoryInterface
{
    /**
     * @param  Duty[]  $storage
     */
    public function __construct(
        private array $storage = [],
    ) {
    }

    public function save(Duty $duty): void
    {
        $this->storage[$duty->getId()->toString()] = $duty;
    }

    public function getAll(): array
    {
        return $this->storage;
    }
}
