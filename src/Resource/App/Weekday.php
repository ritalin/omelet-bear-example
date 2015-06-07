<?php

namespace MyVendor\Weekday\Resource\App;

use BEAR\Resource\ResourceObject;
use Psr\Log\LoggerInterface;

use MyVendor\Weekday\Annotation\BenchMark;

use MyVendor\Weekday\Infra\TodoDao;

class Weekday extends ResourceObject {
    private $logger;
    private $todoDao;
    
    public function __construct(LoggerInterface $logger, TodoDao $todoDao) {
        $this->logger = $logger;
        $this->todoDao = $todoDao;
    }
    
    /**
     * @BenchMark
     */
    public function onGet($year, $month, $day) {
        $this['todo'] = $this->todoDao->listByPub(new \DateTime('2015/4/10'), new \DateTime('2015/5/18'));
        
        $date = \DateTime::createFromFormat('Y-m-d', "$year-$month-$day");
        $this['weekday'] = $date->format("D");
        $this->logger->info("$year-$month-$day {$this['weekday']}");
        
        return $this;
    }
}
