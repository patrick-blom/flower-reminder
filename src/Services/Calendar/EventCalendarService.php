<?php

namespace FlowerReminder\Services\Calendar;

use FlowerReminder\Services\CalendarServiceFactory;
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
     * @var CalendarServiceFactory
     */
    private $calendarServiceFactory;

    /**
     * EventCalendarService constructor.
     * @param ClientFactoryInterface $clientFactory
     */
    public function __construct(ClientFactoryInterface $clientFactory, CalendarServiceFactory $calendarServiceFactory)
    {
        $this->clientFactory = $clientFactory;
        $this->calendarServiceFactory = $calendarServiceFactory;
    }

    /**
     * @param SimpleCalendarEvent $event
     * @return mixed
     */
    public function addSimpleCalendarEvent(SimpleCalendarEvent $event)
    {
        $calendarService = $this->calendarServiceFactory->get(
            \Google_Service_Calendar::class,
            [
                $this->clientFactory->getClient()
            ]
        );

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
        $calendarService = $this->calendarServiceFactory->get(
            \Google_Service_Calendar::class,
            [
                $this->clientFactory->getClient()
            ]
        );

        $googleEvent = $this->calendarServiceFactory->get(
            \Google_Service_Calendar_Event::class,
            [
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
            ]
        );

        /** @var \Google_Service_Calendar_Event $created */
        $created = $calendarService->events->insert($event->calendarId, $googleEvent);

        if ($created) {
            return $created->getId();
        }
    }
}
