<?php

namespace FlowerReminder\Structs;

class AdvancedCalendarEvent extends Base
{
    /**
     * @var string
     */
    public $calendarId;

    /**
     * @var \DateTime
     */
    public $date;

    /**
     * @var string
     */
    public $eventName;
}
