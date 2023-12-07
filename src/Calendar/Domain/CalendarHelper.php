<?php

declare(strict_types=1);

namespace Calendar\Domain;

use Calendar\Domain\Calendar\Calendar;

class CalendarHelper
{
    private Calendar $calendar;
    private array $participants;
    private array $dates;
    private array $responses;
    private array $points;

    public function __construct(Calendar $calendar, array $participants)
    {
        $this->calendar = $calendar;
        $this->participants = $participants;
        $this->dates = $this->prepareDates($this->calendar);
        $this->responses = $this->prepareResponses($this->dates, $participants);
        $this->points = $this->calculatePoints($this->dates, $this->responses);
    }

    public function getCalendar(): Calendar
    {
        return $this->calendar;
    }

    public function getParticipants(): array
    {
        return $this->participants;
    }

    /**
     * @return \DateTimeImmutable[]
     */
    public function getDates(): array
    {
        return $this->dates;
    }

    public function getResponses(): array
    {
        return $this->responses;
    }

    public function getPoints(): array
    {
        return $this->points;
    }

    /**
     * @return \DateTimeImmutable[]
     */
    private function prepareDates(Calendar $calendar): array
    {
        $dates = $calendar->getDates();

        \usort($dates, function (\DateTimeImmutable $first, \DateTimeImmutable $second) {
            return $first > $second ? 1 : -1;
        });

        return $dates;
    }

    private function prepareResponses(array $dates, array $participants): array
    {
        $result = [];

        foreach ($participants as $participant) {
            /** @var \DateTimeImmutable $date */
            foreach ($dates as $date) {
                $date = $date->format('Y-m-d');
                $response = 'not_responded';

                switch (true):
                    case \in_array($date, $participant['will_attend'] ?? []):
                        $response = 'will_attend';
                        break;
                    case \in_array($date, $participant['maybe_attend'] ?? []):
                        $response = 'maybe_attend';
                        break;
                endswitch;

                $result[$participant['username']][$date] = $response;
            }
        }

        return $result;
    }

    private function calculatePoints(array $dates, array $responses): array
    {
        $result = [];

        /** @var \DateTimeImmutable $date */
        foreach ($dates as $date) {
            $result[$date->format('Y-m-d')] = 0;
        }

        foreach ($responses as $data) {
            foreach ($data as $date => $response) {
                if ('will_attend' === $response) {
                    $result[$date]++;
                }
            }
        }

        return $result;
    }
}
