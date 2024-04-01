<?php

declare(strict_types=1);

namespace Modules\Duties\Domain;

final class Duty
{
    /**
     * @param  Enums\DutyEventEnum[]  $events
     */
    public function __construct(
        private readonly ValueObject\DutyId $id,
        private readonly ValueObject\DutyDate $date,
        private readonly ValueObject\DutyCheck $check,
        private readonly Enums\DutyTypeEnum $type,
        private readonly ValueObject\DutyFlight $flight,
        private readonly ValueObject\DutyLocation $location,
        private readonly ValueObject\DutyPeriod $period,
        private readonly array $events = [],
    ) {
    }

    public function getId(): ValueObject\DutyId
    {
        return $this->id;
    }

    public function getDate(): ValueObject\DutyDate
    {
        return $this->date;
    }

    public function getCheck(): ValueObject\DutyCheck
    {
        return $this->check;
    }

    public function getType(): Enums\DutyTypeEnum
    {
        return $this->type;
    }

    public function getFlight(): ValueObject\DutyFlight
    {
        return $this->flight;
    }

    public function getLocation(): ValueObject\DutyLocation
    {
        return $this->location;
    }

    public function getPeriod(): ValueObject\DutyPeriod
    {
        return $this->period;
    }

    public function getEvents(): array
    {
        return $this->events;
    }
}
