<?php
namespace Elastic;

use Elastic\Driver\Connection;
use Illuminate\Support\ServiceProvider;

class ElasticServiceProvider extends ServiceProvider
{
    public function register()
    {

        // Add database driver.
        $this->app->resolving('db', function ($db) {
            $db->extend('elastic', function ($config, $name) {
                $config['name'] = $name;
                return new Connection($config);
            });
        });

        // Add connector for queue support.
        // $this->app->resolving('queue', function ($queue) {
        //     $queue->addConnector('elastic', function () {
        //         return new ElasticConnector($this->app['db']);
        //     });
        // });
    }
}
