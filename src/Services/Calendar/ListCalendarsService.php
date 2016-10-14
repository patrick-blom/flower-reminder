<?php

namespace FlowerReminder\Services\Calendar;

use FlowerReminder\Services\ClientFactoryInterface;

class ListCalendarsService
{
    /**
     * @var ClientFactoryInterface
     */
    private $client;

    /**
     * ListCalendersService constructor.
     * @param ClientFactoryInterface $client
     */
    public function __construct(ClientFactoryInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return array
     */
    public function getCalendarList()
    {
        $calendarService = new \Google_Service_Calendar($this->client->getClient());

        /** @var \Google_Service_Calendar_CalendarList $calendarList */
        $calendarList = $calendarService->calendarList->listCalendarList();

        return $calendarList->getItems();
    }
}
