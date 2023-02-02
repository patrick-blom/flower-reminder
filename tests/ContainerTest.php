<?php declare(strict_types=1);

namespace FlowerReminderTests;

use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function testCanCreateContainer()
    {
        $container = \FlowerReminder\Container::Instance();
        $this->assertInstanceOf('\Symfony\Component\DependencyInjection\ContainerBuilder', $container);
    }
}
