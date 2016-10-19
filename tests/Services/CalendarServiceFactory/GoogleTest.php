<?php


class GoogleTest extends PHPUnit_Framework_TestCase
{

    public function testGetGoogleServiceCalendar()
    {
        $container = \FlowerReminder\Container::Instance();
        $serviceFactory = $container->get('flower_reminder.services.calendar_service_factory.google');

        $gcs = $serviceFactory->get(\Google_Service_Calendar::class, [$this->createMock('\Google_Client')]);

        $this->assertInstanceOf(\Google_Service_Calendar::class, $gcs);
    }

    public function testGetGoogleServiceCalendarEvent()
    {
        $container = \FlowerReminder\Container::Instance();
        $serviceFactory = $container->get('flower_reminder.services.calendar_service_factory.google');

        $gcs = $serviceFactory->get(\Google_Service_Calendar_Event::class);

        $this->assertInstanceOf(\Google_Service_Calendar_Event::class, $gcs);
    }
}
