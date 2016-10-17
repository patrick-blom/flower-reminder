<?php


class ContainerTest extends PHPUnit_Framework_TestCase
{
    public function testCanCreateContainer()
    {
        $container = \FlowerReminder\Container::Instance();
        $this->assertInstanceOf('\Symfony\Component\DependencyInjection\ContainerBuilder', $container);
    }
}
