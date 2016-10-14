<?php

namespace FlowerReminder\Services;

interface ClientFactoryInterface
{
    /**
     * @return mixed
     */
    public function getClient();
}
