<?php


use FlowerReminder\Services\Calendar\ListCalendarsService;
use FlowerReminder\Services\ClientFactory\Google;
use FlowerReminder\Services\CalendarServiceFactory\Google as ServiceGoogle;

class ListCalendarsServiceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Google
     */
    private $clientFactory;

    /**
     * @var ServiceGoogle
     */
    private $serviceFactory;

    protected function setUp()
    {
        $this->clientFactory = $this->getMockBuilder('FlowerReminder\Services\ClientFactory\Google')
            ->disableOriginalConstructor()
            ->getMock();

        $this->serviceFactory = $this->getMockBuilder('FlowerReminder\Services\CalendarServiceFactory\Google')
            ->disableOriginalConstructor()
            ->getMock();
    }


    public function testCanCreateClass()
    {
        $eventService = new ListCalendarsService($this->clientFactory, $this->serviceFactory);
        $this->assertInstanceOf('FlowerReminder\Services\Calendar\ListCalendarsService', $eventService);
    }
}
