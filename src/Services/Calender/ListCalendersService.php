<?php

namespace FlowerReminder\Services\Calender;

use FlowerReminder\Services\ClientFactoryInterface;

class ListCalendersService
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

    public function getCalenderList()
    {
        $calenderService = new \Google_Service_Calendar($this->client->getClient());

        $result = $calenderService->calendarList->listCalendarList();

        var_dump($result);
    }
}
