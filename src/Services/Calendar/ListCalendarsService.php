<?php

namespace FlowerReminder\Services\Calendar;

use FlowerReminder\Services\CalendarServiceFactory;
use FlowerReminder\Services\ClientFactoryInterface;

class ListCalendarsService
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
     * ListCalendarsService constructor.
     * @param ClientFactoryInterface $clientFactory
     * @param CalendarServiceFactory $calendarServiceFactory
     */
    public function __construct(ClientFactoryInterface $clientFactory, CalendarServiceFactory $calendarServiceFactory)
    {
        $this->clientFactory = $clientFactory;
        $this->calendarServiceFactory = $calendarServiceFactory;
    }

    /**
     * @return array
     */
    public function getCalendarList()
    {
        $calendarService = $this->calendarServiceFactory->get(
            \Google_Service_Calendar::class,
            [
                $this->clientFactory->getClient()
            ]
        );

        /** @var \Google_Service_Calendar_CalendarList $calendarList */
        $calendarList = $calendarService->calendarList->listCalendarList();

        return $calendarList->getItems();
    }
}
