<?php

namespace FlowerReminder\Commands;

use FlowerReminder\Container;
use FlowerReminder\Services\RandomizingReminder;
use FlowerReminder\Structs\AdvancedCalendarEvent;
use FlowerReminder\Structs\RandomReminderConfig;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateRandomCalendarEventsCommand extends Command
{
    protected function configure()
    {
        $this->setName('reminder:calendar:create:random')
            ->setDescription('Creates random calendar events based on default config or options')
            ->addArgument(
                'calendarId',
                InputArgument::REQUIRED,
                'The Google calendar id'
            )
            ->addOption(
                'startdate',
                null,
                InputOption::VALUE_OPTIONAL,
                'The start date for the random event generation (default: now)',
                (new \DateTime())->format('Y-m-d H:i:s')
            )
            ->addOption(
                'interval-in-months',
                null,
                InputOption::VALUE_OPTIONAL,
                'The count of months for one intervall (defalut: 3)',
                3
            )
            ->addOption(
                'remindings-per-intervall',
                null,
                InputOption::VALUE_OPTIONAL,
                'The count of remindings per interval (default: 2)',
                2
            )
            ->addOption(
                'intervals',
                null,
                InputOption::VALUE_OPTIONAL,
                'The loop of intervals (default: 4)',
                4
            );
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
        $reminderConfig = new RandomReminderConfig(
            [
                'startDate' => \DateTime::createFromFormat('Y-m-d H:i:s', $input->getOption('startdate')),
                'intervalInMonths' => $input->getOption('interval-in-months'),
                'remindingsPerInterval' => $input->getOption('remindings-per-intervall'),
                'intervals' => $input->getOption('intervals')
            ]
        );

        $reminderService = new RandomizingReminder($reminderConfig);

        $container = Container::Instance();
        $calendarEventService = $container->get('flower_reminder.service.calender.event_calendar_service');

        try {
            $io->note('Creating random events');
            $dates = $reminderService->generateReminderDates();
            $randomEvents = [];

            /** @var \DateTime $date */
            foreach ($dates as $date) {
                $newEvent = new AdvancedCalendarEvent(
                    [
                        'calendarId' => $calendarId,
                        'date' => $date,
                        'eventName' => $container->getParameter('calendar_msg')
                    ]
                );

                if ($eventId = $calendarEventService->addCalendarEvent($newEvent)) {
                    array_push($randomEvents, [
                        $eventId, $date->format('Y-m-d')
                    ]);
                }
            }

            $io->table(
                ['Event Id', 'Calendar Date'],
                $randomEvents
            );

            $io->success('Events created');
        } catch (\Exception $exception) {
            $io->error($exception->getMessage());
            return 1;
        }

        return 0;
    }
}
