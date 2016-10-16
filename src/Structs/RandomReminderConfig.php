<?php

namespace FlowerReminder\Structs;

class RandomReminderConfig extends Base
{
    /**
     * @var \DateTime
     */
    public $startDate;

    /**
     * @var integer
     */
    public $intervalInMonths;

    /**
     * @var integer
     */
    public $remindingsPerInterval;

    /**
     * @var integer
     */
    public $intervals;

    /**
     * @var boolean
     */
    public $multipleRemindingsPerMonth;
}
