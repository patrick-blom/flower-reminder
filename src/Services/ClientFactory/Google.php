<?php

namespace FlowerReminder\Services\ClientFactory;

use FlowerReminder\Services\ClientFactoryInterface;

class Google implements ClientFactoryInterface
{
    /**
     * @var string
     */
    private $configFile;

    /**
     * Google constructor.
     * @param $configFile
     */
    public function __construct($configFile)
    {
        $this->configFile = $configFile;
    }

    /**
     * @return \Google_Client
     */
    public function getClient()
    {
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/../../../config/' . $this->configFile);
        $client = new \Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope(\Google_Service_Calendar::CALENDAR);
        return $client;
    }
}
