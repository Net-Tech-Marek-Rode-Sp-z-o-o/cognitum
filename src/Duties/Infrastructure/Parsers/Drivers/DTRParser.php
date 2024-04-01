<?php

declare(strict_types=1);

namespace Modules\Duties\Infrastructure\Parsers\Drivers;

use Carbon\Carbon;
use DOMDocument;
use DOMElement;
use DOMNodeList;
use Illuminate\Support\Str;
use Modules\Duties\Domain\Duty;
use Modules\Duties\Domain\Enums\DutyEventEnum;
use Modules\Duties\Domain\Enums\DutyTypeEnum;
use Modules\Duties\Domain\ValueObject as VO;
use Modules\Duties\Infrastructure\Parsers\ParserInterface;

final class DTRParser implements ParserInterface
{
    public const ID_TABLE = 'ctl00_Main_activityGrid';

    public const ID_SELECT = 'ctl00_Main_periodSelect';

    public function handle(string $content): array
    {
        $content = trim($content, " \t\n\r\0\x0B\xc2\xa0");
        if (empty($content)) {
            return [];
        }

        libxml_use_internal_errors(true);
        $document = new DOMDocument();
        $document->loadHTML($content);

        $select = $document->getElementById(self::ID_SELECT);
        $selectedPeriod = $select->getElementsByTagName('option')->item(0)->nodeValue;
        preg_match(
            '/(?P<start>\w+)\.\./i',
            $selectedPeriod,
            $matches,
        );

        if (! isset($matches['start'])) {
            return [];
        }

        $selectedDate = Carbon::parse($matches['start']);

        /** @var DOMElement $table */
        $table = $document->getElementById(self::ID_TABLE);

        $duties = [];
        $day = $selectedDate->day;
        /** @var DOMElement $row */
        foreach ($table->getElementsByTagName('tr') as $i => $row) {
            if ($i === 0) {
                // skip header
                continue;
            }

            /** @var DOMNodeList $columns */
            $columns = $row->getElementsByTagName('td');

            $date = (string) $columns->item(1)->nodeValue;
            @[$dayOfWeek, $dayOfMonth] = explode(' ', $date);

            if ((int) $dayOfMonth > 0) {
                $day = (int) $dayOfMonth;
            }

            $checkIn = (string) $columns->item(5)->nodeValue;
            $checkOut = (string) $columns->item(7)->nodeValue;

            $activity = (string) $columns->item(8)->nodeValue;

            $from = (string) $columns->item(11)->nodeValue;
            $to = (string) $columns->item(15)->nodeValue;

            $departure = (string) $columns->item(13)->nodeValue;
            $arrival = (string) $columns->item(17)->nodeValue;

            $currentDate = Carbon::parse($selectedDate)->day($day);

            $checkInDate = $this->getDateForTime($currentDate, $checkIn);
            $checkOutDate = $this->getDateForTime($currentDate, $checkOut);

            $events = [$activityType = $this->getActivity($activity)];

            if ($checkInDate) {
                $events[] = DutyEventEnum::CI;
            }

            if ($checkOutDate) {
                $events[] = DutyEventEnum::CO;
            }

            $duties[] = new Duty(
                id: VO\DutyId::getNew(),
                date: new VO\DutyDate($currentDate),
                check: new VO\DutyCheck(in: $checkInDate, out: $checkOutDate),
                type: $this->type(),
                flight: new VO\DutyFlight($activityType->isFlight() ? $activity : null),
                location: new VO\DutyLocation(from: $from, to: $to),
                period: new VO\DutyPeriod(
                    departure: $this->getDateForTime($currentDate, $departure),
                    arrival: $this->getDateForTime($currentDate, $arrival),
                ),
                events: $events,
            );
        }

        return $duties;
    }

    public function type(): DutyTypeEnum
    {
        return DutyTypeEnum::DTR;
    }

    private function getDateForTime(Carbon $currentDate, string $time): ?Carbon
    {
        $time = trim($time, " \t\n\r\0\x0B\xc2\xa0");

        if (empty($time)) {
            return null;
        }

        $base = Carbon::parse($currentDate);

        if (Str::length($time) === 6) {
            $day = Str::substr($time, 4, 6);
            $base = (intval($day) > 0 ? $base->addDay() : $base->subDay());
        }

        return $base->setTime(
            hour: (int) Str::substr($time, 0, 2),
            minute: (int) Str::substr($time, 2, 2),
        );
    }

    private function getActivity(string $activity): DutyEventEnum
    {
        if (Str::isMatch('/\w{2}\d{2,}/i', $activity)) {
            return DutyEventEnum::FLT;
        }

        if (Str::isMatch('/OFF/i', $activity)) {
            return DutyEventEnum::DO;
        }

        if (Str::isMatch('/SBY/i', $activity)) {
            return DutyEventEnum::SBY;
        }

        return DutyEventEnum::UNK;
    }
}
