<?php

namespace ChasseBundle\Service;

use Monolog\Logger;

class Cachetest
{
    /**
     * @var Logger
     */
    private $logger;

    public function __construct(Logger $logger)
    {

        $this->logger = $logger;
        $this->logger->info('Appel au cache fait.');
    }

}