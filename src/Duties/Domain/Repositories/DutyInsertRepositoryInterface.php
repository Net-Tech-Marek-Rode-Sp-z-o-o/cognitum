<?php

declare(strict_types=1);

namespace Modules\Duties\Domain\Repositories;

use Modules\Duties\Domain\Duty;

interface DutyInsertRepositoryInterface
{
    public function save(Duty $duty): void;
}
