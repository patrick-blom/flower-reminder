<?php

namespace FlowerReminder\Services\Calendar;

use FlowerReminder\Services\ClientFactoryInterface;
use FlowerReminder\Structs\AdvancedCalendarEvent;
use FlowerReminder\Structs\SimpleCalendarEvent;

class EventCalendarService
{
    /**
     * @var ClientFactoryInterface
     */
    private $clientFactory;

    /**
     * EventCalendarService constructor.
     * @param ClientFactoryInterface $clientFactory
     */
    public function __construct(ClientFactoryInterface $clientFactory)
    {
        $this->clientFactory = $clientFactory;
    }

    /**
     * @param SimpleCalendarEvent $event
     * @return mixed
     */
    public function addSimpleCalendarEvent(SimpleCalendarEvent $event)
    {
        $calendarService = new \Google_Service_Calendar($this->clientFactory->getClient());

        /** @var \Google_Service_Calendar_Event $created */
        $created = $calendarService->events->quickAdd($event->calendarId, $event->eventString);

        if ($created) {
            return $created->getId();
        }
    }

    /**
     * @param AdvancedCalendarEvent $event
     * @return mixed
     */
    public function addCalendarEvent(AdvancedCalendarEvent $event)
    {
        $calendarService = new \Google_Service_Calendar($this->clientFactory->getClient());

        $googleEvent = new \Google_Service_Calendar_Event(
            [
                'summary' => $event->eventName,
                'description' => $event->eventDescription,
                'start' => [
                    'dateTime' => $event->date->format('Y-m-d') . 'T' . $event->startTime,
                    'timeZone' => $event->date->getTimezone()->getName(),
                ],
                'end' => [
                    'dateTime' => $event->date->format('Y-m-d') . 'T' . $event->endTime,
                    'timeZone' => $event->date->getTimezone()->getName(),
                ],
                'attendees' => [
                    ['email' => $event->reminderEmail]
                ],
                'reminders' => [
                    'useDefault' => false,
                    'overrides' => [
                        ['method' => 'email', 'minutes' => $event->reminderTime],
                    ],
                ],
            ]
        );

        /** @var \Google_Service_Calendar_Event $created */
        $created = $calendarService->events->insert($event->calendarId, $googleEvent);

        if ($created) {
            return $created->getId();
        }
    }
}
