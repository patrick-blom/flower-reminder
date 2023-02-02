<?php
declare(strict_types=1);

namespace FlowerReminderTests\Services\Calendar;

use PHPUnit\Framework\TestCase;
use FlowerReminder\Services\Calendar\ListCalendarsService;
use FlowerReminder\Services\ClientFactory\Google;
use FlowerReminder\Services\CalendarServiceFactory\Google as ServiceGoogle;

class ListCalendarsServiceTest extends TestCase
{
    /**
     * @var Google
     */
    private $clientFactory;

    /**
     * @var ServiceGoogle
     */
    private $serviceFactory;

    protected function setUp(): void
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
