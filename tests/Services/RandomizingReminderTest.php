<?php
declare(strict_types=1);

namespace FlowerReminderTests\Services;

use PHPUnit\Framework\TestCase;
use \FlowerReminder\Services\RandomizingReminder;
use  \FlowerReminder\Structs\RandomReminderConfig;

class RandomizingReminderTest extends TestCase
{
    public function testCanCreateInstance()
    {
        $rr = new RandomizingReminder(
            new RandomReminderConfig()
        );

        $this->assertInstanceOf('\FlowerReminder\Services\RandomizingReminder', $rr);
    }

    public function testCanCreateOneRandomDate()
    {
        $config = new RandomReminderConfig(
            [
                'startDate' => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-01-01 00:00:01'),
                'intervalInMonths' => 3,
                'remindingsPerInterval' => 1,
                'intervals' => 1,
                'multipleRemindingsPerMonth' => true
            ]
        );

        $rr = new RandomizingReminder($config);

        $result = $rr->generateReminderDates();

        $this->assertIsArray($result);
        $this->assertInstanceOf('\DateTime', $result[0]);
        $this->assertCount(1, $result);

        $endDate = \DateTime::createFromFormat('Y-m-d H:i:s', '2016-04-01 00:00:01');
        /** @var \DateTime $resultDate */
        $resultDate = array_shift($result);
        $this->assertTrue(
            (
                $resultDate->getTimestamp() > $config->startDate->getTimestamp()
                && $resultDate->getTimestamp() < $endDate->getTimestamp()
            )
        );
    }

    public function testCanCreateMultipleRandomDatesInTheSameMonth()
    {
        $config = new RandomReminderConfig(
            [
                'startDate' => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-01-01 00:00:01'),
                'intervalInMonths' => 1,
                'remindingsPerInterval' => 2,
                'intervals' => 1,
                'multipleRemindingsPerMonth' => true
            ]
        );

        $rr = new RandomizingReminder($config);

        $result = $rr->generateReminderDates();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);

        $endDate = \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-01 00:00:01');
        /** @var DateTime $item */
        foreach ($result as $item) {
            $this->assertInstanceOf('\DateTime', $item);
            $this->assertTrue(
                (
                    $item->getTimestamp() > $config->startDate->getTimestamp()
                    && $item->getTimestamp() < $endDate->getTimestamp()
                )
            );
        }
    }

    public function testCanCreateMultipleRandomDatesNotInTheSameMonth()
    {
        $config = new RandomReminderConfig(
            [
                'startDate' => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-01-01 00:00:01'),
                'intervalInMonths' => 1,
                'remindingsPerInterval' => 1,
                'intervals' => 2,
                'multipleRemindingsPerMonth' => false
            ]
        );

        $rr = new RandomizingReminder($config);

        $result = $rr->generateReminderDates();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);

        $matrix = [
            '01' => false,
            '02' => false
        ];

        /** @var DateTime $item */
        foreach ($result as $item) {
            $this->assertInstanceOf('\DateTime', $item);
            $month = date('m', $item->getTimestamp());

            $this->assertArrayHasKey($month, $matrix);

            $matrix[$month] = true;
            $this->assertTrue($matrix[$month]);
        }

        $res = array_unique($matrix);
        $this->assertCount(1, $res);
        $this->assertTrue(array_shift($res));
    }
}
