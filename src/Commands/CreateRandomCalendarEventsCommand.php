<?php

namespace FlowerReminder\Commands;

use FlowerReminder\Container;
use FlowerReminder\Services\RandomizingReminder;
use FlowerReminder\Structs\AdvancedCalendarEvent;
use FlowerReminder\Structs\RandomReminderConfig;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
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
            )
            ->addOption(
                'multiple-reminders-per-month',
                null,
                InputOption::VALUE_OPTIONAL,
                'Allow Multiple remindings in a single month (default: 0)',
                0
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
                'intervals' => $input->getOption('intervals'),
                'multipleRemindingsPerMonth' => boolval($input->getOption('multiple-reminders-per-month'))
            ]
        );

        $reminderService = new RandomizingReminder($reminderConfig);

        $container = Container::Instance();
        $calendarEventService = $container->get('flower_reminder.service.calender.event_calendar_service');

        try {
            $io->note('Creating random events');
            $dates = $reminderService->generateReminderDates();
            $randomEvents = [];

            $progressBar = new ProgressBar($output,count($dates));
            $progressBar->start();

            /** @var \DateTime $date */
            foreach ($dates as $date) {
                $newEvent = new AdvancedCalendarEvent(
                    [
                        'calendarId' => $calendarId,
                        'date' => $date,
                        'startTime' => $container->getParameter('calendar_event_starttime'),
                        'endTime' => $container->getParameter('calendar_event_endtime'),
                        'eventName' => $container->getParameter('calendar_event_msg'),
                        'eventDescription' => $container->getParameter('calendar_event_msg_description'),
                        'reminderEmail' => $container->getParameter('calendar_event_reminder_mail'),
                        'reminderTime' => $container->getParameter('calendar_event_reminder_in_minutes'),
                    ]
                );

                $progressBar->advance();
                if ($eventId = $calendarEventService->addCalendarEvent($newEvent)) {
                    array_push($randomEvents, [
                        $eventId, $date->format('Y-m-d')
                    ]);
                }
            }

            $progressBar->finish();

            $io->writeln('');
            $io->note('Listing events');

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
