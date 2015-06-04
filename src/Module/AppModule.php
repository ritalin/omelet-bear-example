<?php

namespace MyVendor\Weekday\Module;

use BEAR\Package\PackageModule;
use Ray\Di\AbstractModule;
use BEAR\Package\Provide\Router\AuraRouterModule;
use Psr\Log\LoggerInterface;
use Ray\Di\Scope;

use MyVendor\Weekday\Annotation\BenchMark;
use MyVendor\Weekday\Interceptor\Benchmarker;

use Omelet\Module\DaoBuilderBearModule;

use MyVendor\Weekday\Infra\TodoDao;

class AppModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->install(new PackageModule);
        $this->override(new AuraRouterModule);
        $this->bind(LoggerInterface::class)
            ->toProvider(MonologLoggerProvider::class)
            ->in(Scope::SINGLETON);
        
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith(BenchMark::class),
            [BenchMarker::class]
        );
        
        $projectRoot = dirname(dirname(__DIR__));
        
        $daoConf = new Configuration(function ($c) use($projectRoot) {
            $c->daoClassPath = $projectRoot . '/var/tmp/auto_generated';
            $c->sqlRootDir = $projectRoot . '/sql';
            $c->watchMode = 'Always';
            $c->returnCaseSensor = 'UpperSnake';
            $c->connectionString = http_build_query([
                'driver' => 'pdo_sqlite', 'path' => $projectRoot . '/var/db/todo.sqlite3'
            ]);
        });
        
        $this->install(new DaoBuilderBearModule($daoConf, [
            TodoDao::class,
        ]));
    }
}
