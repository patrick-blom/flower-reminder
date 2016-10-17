<?php

namespace FlowerReminder\Services\CalendarServiceFactory;

use FlowerReminder\Services\CalendarServiceFactory;

class Google implements CalendarServiceFactory
{

    /**
     * @param string $className
     * @param array $arguments
     * @return object
     */
    public function get($className = "", $arguments = [])
    {
        $class = new \ReflectionClass($className);
        return $class->newInstanceArgs($arguments);
    }
}
