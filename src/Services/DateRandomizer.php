<?php

namespace FlowerReminder\Services;

use FlowerReminder\Structs\RandomDateConfig;
use Psr\Log\LoggerInterface;

class DateRandomizer
{
    /**
     * @var RandomDateConfig
     */
    private $dateConfig;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * DateRandomizer constructor.
     * @param RandomDateConfig $dateConfig
     */
    public function __construct(RandomDateConfig $dateConfig, LoggerInterface $logger)
    {
        $this->dateConfig = $dateConfig;
        $this->logger = $logger;
    }

    public function getDates()
    {
        $date = [];

        $startMonth = date('w', $this->dateConfig->startDate);
        $endMonth = $startMonth + $this->dateConfig->durationInMonth;

        $this->logger->info('starting random date calculation from month ' . $startMonth . ' to ' . $endMonth);

        for ($month = $startMonth; $month <= $endMonth; $month++) {
            array_push(
                $date,
                $this->getRandomDay($month)
            );
        }
    }

    private function getRandomDay($month)
    {


        return new \DateTime();
    }

}
