<?php

namespace FlowerReminder\Services;

use FlowerReminder\Structs\RandomReminderConfig;
use Psr\Log\LoggerInterface;

class RandomizingReminder
{
    /**
     * @var RandomReminderConfig
     */
    private $reminderConfig;

    /**
     * RandomizingReminder constructor.
     * @param RandomReminderConfig $reminderConfig
     */
    public function __construct(RandomReminderConfig $reminderConfig)
    {
        $this->reminderConfig = $reminderConfig;
    }

    /**
     * @return array
     */
    public function generateReminderDates()
    {

        $dates = [];

        /** @var \DateTime $nextDate */
        $nextDate = $this->reminderConfig->startDate;
        $loops = 1;

        do {
            $endDate = clone $nextDate;
            $endDate->modify('+' . $this->reminderConfig->intervalInMonths . ' month');

            for ($i = 1; $i <= $this->reminderConfig->remindingsPerInterval; $i++) {
                $randomTimeStamp = mt_rand($nextDate->getTimestamp(), $endDate->getTimestamp());
                $reminderDate = new \DateTime();
                $reminderDate->setTimestamp($randomTimeStamp);
                array_push($dates, $reminderDate);
            }

            $nextDate = $endDate;
            $loops++;

        } while ($loops <= $this->reminderConfig->intervals);

        return $dates;
    }


}
