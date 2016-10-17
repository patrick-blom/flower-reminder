<?php


namespace FlowerReminder\Services;


interface CalendarServiceFactory
{

    /**
     * @param string $className
     * @param array $arguments
     * @return mixed
     */
    public function get($className = "", $arguments = []);
}
