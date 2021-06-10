<?php
namespace\Elastic;

use Illuminate\Support\ServiceProvider;

class ClassName extends ServiceProvider
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
        //     $queue->addConnector('mongodb', function () {
        //         return new MongoConnector($this->app['db']);
        //     });
        // });
    }
}
