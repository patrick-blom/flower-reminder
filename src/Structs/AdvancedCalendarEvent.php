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
    public $startTime;

    /**
     * @var string
     */
    public $endTime;

    /**
     * @var string
     */
    public $eventName;

    /**
     * @var string
     */
    public $eventDescription;

    /**
     * @var string
     */
    public $reminderEmail;

    /**
     * @var integer
     */
    public $reminderTime;

}
