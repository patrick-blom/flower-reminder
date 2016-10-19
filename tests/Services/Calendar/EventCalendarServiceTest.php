<?php


use FlowerReminder\Services\Calendar\EventCalendarService;
use FlowerReminder\Services\ClientFactory\Google;

class EventCalendarServiceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Google
     */
    private $clientFactory;

    protected function setUp()
    {
        $this->clientFactory = $this->getMockBuilder('FlowerReminder\Services\ClientFactory\Google')
            ->disableOriginalConstructor()
            ->setMethods(['getClient'])
            ->getMock();

        $this->clientFactory->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($this->createMock('\Google_Client')));
    }

    public function testCanCreateClass()
    {
        $serviceFactory = $this->getMockBuilder('FlowerReminder\Services\CalendarServiceFactory\Google')
            ->disableOriginalConstructor()
            ->setMethods(['get'])
            ->getMock();

        $eventService = new EventCalendarService($this->clientFactory, $serviceFactory);
        $this->assertInstanceOf('FlowerReminder\Services\Calendar\EventCalendarService', $eventService);
    }

    public function testCanAddSimpleCalendarEvent()
    {
        $calendarEventMock = $this->getMockBuilder('\Google_Service_Calendar')
            ->disableOriginalConstructor()
            ->getMock();

        $dummyEvent = new Google_Service_Calendar_Event();
        $dummyEvent->setId('abcdefg12345');

        $calendarEventMock->events = $this->getMockBuilder('\Google_Service_Calendar_Resource_Events')
            ->disableOriginalConstructor()
            ->setMethods(['quickAdd'])
            ->getMock();
        $calendarEventMock->events->expects($this->any())
            ->method('quickAdd')
            ->withAnyParameters()
            ->will($this->returnValue($dummyEvent));


        $serviceFactory = $this->getMockBuilder('FlowerReminder\Services\CalendarServiceFactory\Google')
            ->disableOriginalConstructor()
            ->setMethods(['get'])
            ->getMock();
        $serviceFactory->expects($this->any())
            ->method('get')
            ->with($this->equalTo(\Google_Service_Calendar::class), $this->anything())
            ->will($this->returnValue($calendarEventMock));


        $eventService = new EventCalendarService($this->clientFactory, $serviceFactory);
        $id = $eventService->addSimpleCalendarEvent(new \FlowerReminder\Structs\SimpleCalendarEvent());

        $this->assertEquals('abcdefg12345', $id);

    }

    public function testCanAddCalendarEvent()
    {
        $calendarEventMock = $this->getMockBuilder('\Google_Service_Calendar')
            ->disableOriginalConstructor()
            ->getMock();

        $dummyEvent = new Google_Service_Calendar_Event();
        $dummyEvent->setId('abcdefg12345');

        $calendarEventMock->events = $this->getMockBuilder('\Google_Service_Calendar_Resource_Events')
            ->disableOriginalConstructor()
            ->setMethods(['insert'])
            ->getMock();
        $calendarEventMock->events->expects($this->any())
            ->method('insert')
            ->withAnyParameters()
            ->will($this->returnValue($dummyEvent));


        $serviceFactory = $this->getMockBuilder('FlowerReminder\Services\CalendarServiceFactory\Google')
            ->disableOriginalConstructor()
            ->setMethods(['get'])
            ->getMock();

        $serviceFactory->expects($this->at(0))
            ->method('get')
            ->with($this->equalTo(\Google_Service_Calendar::class),$this->anything())
            ->will($this->returnValue($calendarEventMock));

        $serviceFactory->expects($this->at(1))
            ->method('get')
            ->with($this->equalTo(\Google_Service_Calendar_Event::class),$this->anything())
            ->will($this->returnValue($dummyEvent));

        $eventService = new EventCalendarService($this->clientFactory, $serviceFactory);
        $id = $eventService->addCalendarEvent(new \FlowerReminder\Structs\AdvancedCalendarEvent(
            [
                'date' => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-06-04 11:00:00')
            ]
        ));

        $this->assertEquals('abcdefg12345', $id);
    }
}
