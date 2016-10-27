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
                if (
                    !$this->reminderConfig->multipleRemindingsPerMonth &&
                    count($dates) > 0 &&
                    $this->reminderConfig->remindingsPerInterval <= $this->reminderConfig->intervalInMonths &&
                    (date('m', $randomTimeStamp) == date('m', $dates[(count($dates) - 1)]->getTimestamp()))
                ) {
                    $i--;
                } else {
                    $reminderDate = new \DateTime();
                    $reminderDate->setTimestamp($randomTimeStamp);
                    array_push($dates, $reminderDate);
                }

            }

            $nextDate = $endDate;
            $loops++;

        } while ($loops <= $this->reminderConfig->intervals);

        return $this->sortByTimestamp($dates);
    }

    /**
     * @param $dates
     * @return mixed
     */
    private function sortByTimestamp($dates)
    {
        usort($dates,
            function ($date_a, $date_b) {
                if ($date_a->getTimestamp() == $date_b->getTimestamp()) {
                    return 0;
                }

                return ($date_a->getTimestamp() < $date_b->getTimestamp()) ? -1 : 1;
            }
        );

        return $dates;
    }

}
