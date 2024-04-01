<?php

declare(strict_types=1);

namespace Modules\Duties\Domain\Enums;

enum DutyEventEnum: string
{
    case DO = 'Off';
    case SBY = 'Standby';
    case FLT = 'Flight';
    case CI = 'CheckIn';
    case CO = 'CheckOut';
    case UNK = 'Unknown';

    public function isOff(): bool
    {
        return $this->equals(self::DO);
    }

    public function isFlight(): bool
    {
        return $this->equals(self::FLT);
    }

    public function equals(DutyEventEnum $type): bool
    {
        return $this === $type;
    }
}
