<?php

namespace MyVendor\Weekday\Interceptor;

use Psr\Log\LoggerInterface;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;

class Benchmarker implements MethodInterceptor {
    private $logger;
    
    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
    }
    
    public function invoke(MethodInvocation $invocation) {
        $start = microtime(true);
        $result = $invocation->proceed();
        $time = microtime(true);
        $msg = sprintf("%s: %d", $invocation->getMethod()->getName(), $time - $start);
        $this->logger->info($msg);
        
        return $result;
    }
}
