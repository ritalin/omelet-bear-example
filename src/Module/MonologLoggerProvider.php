<?php

namespace MyVendor\Weekday\Module;

use BEAR\AppMeta\AbstractAppMeta;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Ray\Di\ProviderInterface;

class MonologLoggerProvider implements ProviderInterface {
    /**
     * @var AbstractAppMeta
     */
    private $appmeta;
    
    public function __construct(AbstractAppMeta $appmeta) {
        $this->appmeta = $appmeta;
    }
    
    public function get() {
        $log = new Logger('weekday');
        $log->pushHandler(new StreamHandler($this->appmeta->logDir . '/weekday.log'));
        
        return $log;
    }
}
