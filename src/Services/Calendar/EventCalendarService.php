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
        return true;
    }
}
