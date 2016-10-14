<?php

namespace FlowerReminder\Commands;

use FlowerReminder\Container;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ListCalendarsCommand extends Command
{
    protected function configure()
    {
        $this->setName('reminder:calendar:list')
            ->setDescription('Get a list of all clandars');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $container = Container::Instance();
        $listCalenderService = $container->get('flower_reminder.service.calender.list_calendar_service');
        $calendars = $listCalenderService->getCalendarList();

        if (!$calendars) {
            $io->caution([
                "Could not find calendar elements",
                "Check key or calendar share settings"
            ]);
            return 1;
        }

        $tableData = [];

        /** @var \Google_Service_Calendar_CalendarListEntry $calendar */
        foreach ($calendars as $calendar) {
            array_push($tableData, [
                $calendar->getSummary(),
                $calendar->getId()
            ]);
        }

        $io->table(
            ['Calendar', 'id'],
            $tableData
        );
        return 0;
    }
}
