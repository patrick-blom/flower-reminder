<?php


use FlowerReminder\Services\Calendar\EventCalendarService;
use FlowerReminder\Services\ClientFactory\Google;
use FlowerReminder\Services\CalendarServiceFactory\Google as ServiceGoogle;

class EventCalendarServiceTest extends PHPUnit_Framework_TestCase
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
        $eventService = new EventCalendarService($this->clientFactory, $this->serviceFactory);
        $this->assertInstanceOf('FlowerReminder\Services\Calendar\EventCalendarService', $eventService);
    }

    public function testCanAddSimpleCalendarEvent()
    {
        $this->markTestIncomplete('Todo: implement test logic for ' . __METHOD__);
    }

    public function testCanAddCalendarEvent()
    {
        $this->markTestIncomplete('Todo: implement test logic for ' . __METHOD__);
    }
}
