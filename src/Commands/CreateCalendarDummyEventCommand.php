<?php

namespace FlowerReminder\Commands;

use FlowerReminder\Container;
use FlowerReminder\Structs\SimpleCalendarEvent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateCalendarDummyEventCommand extends Command
{
    protected function configure()
    {
        $this->setName('reminder:calendar:create:dummy')
            ->setDescription('Creates a dummy event on November 3rd to ensure the functionality of the app')
            ->addArgument('calendarId', InputArgument::REQUIRED, 'The Google calendar id');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $calendarId = $input->getArgument('calendarId');

        $container = Container::Instance();
        $calendarEventService = $container->get('flower_reminder.service.calender.event_calendar_service');

        $dummyEvent = new SimpleCalendarEvent(
            [
                'calendarId' => $calendarId,
                'appointmentString' => 'Buy your women some flowers on November 3rd 10am-10:25am'
            ]
        );

        $createdId = $calendarEventService->addSimpleCalendarEvent($dummyEvent);

        if (!$createdId) {
            $io->caution('could not create calendar event');
            return 1;
        }

        $io->success('Event with id ' . $createdId . ' created');

        return 0;
    }
}
