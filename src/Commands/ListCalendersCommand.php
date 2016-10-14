<?php

namespace FlowerReminder\Commands;

use FlowerReminder\Container;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListCalendersCommand extends Command
{
    protected function configure()
    {
        $this->setName('reminder:calender:list')
            ->setDescription('Get a list of all clanders');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = Container::Instance();
        $listCalenderService = $container->get('flower_reminder.service.calender.list_calender_service');

        $listCalenderService->getCalenderList();

    }
}
