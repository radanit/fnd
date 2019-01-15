<?php

namespace App\Radan\Config\Providers;

use App\Radan\Config\Storage\File;
use App\Radan\Config\Storage\Pdo;
use App\Radan\Config\Storage\Redis;
use App\Radan\Config\Storage\Elequent;
use App\Radan\Config\Storage\StorageInterface;
use App\Radan\Config\Config;
use Illuminate\Contracts\Config\Repository as LaravelConfig;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Service Provider for Config
 *
 * @package App\Radan\Config;
 */
class ServiceProvider extends BaseServiceProvider
{
    protected $defer = false;

    /**
     * @inheritdoc
     */
    public function boot()
    {
        # publish necessary files        
    }

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->app->singleton('config-runtime', function () {
            $storage = $this->selectStorage($this->app['config']);
            if ($storage === null) {
                $storage = [];
            }
            $cfg = new Config($storage);
            $modifiers = $this->app['config']->get('config.modifiers', []);
            foreach ($modifiers as $className) {
                $cfg->modifiers->push(new $className);
            }

            return $cfg;
        });
    }

    /**
     * Define the services this provider will build & provide
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'App\Radan\Config\Config',
            'config-runtime'
        ];
    }

    /**
     * Retrieve the storage engine, based on the current configuration
     *
     * @param  LaravelConfig $config
     * @return StorageInterface
     */
    protected function selectStorage($config)
    {
        if (!$config->get('config.storage.enabled')) {
            return null;
        }
        $driver = $config->get('config.storage.driver', 'file');
        $method = 'selectStorage'.ucfirst($driver);
        return $this->$method($config);
    }

    /**
     * Get an instance of the PDO storage engine
     *
     * @param  LaravelConfig $config
     * @return Pdo
     */
    protected function selectStoragePdo($config)
    {
        $connection = $config->get('config.storage.connection');
        $table = $this->app['db']->getTablePrefix() . 'config';
        $pdo = $this->app['db']->connection($connection)->getPdo();
        return new Pdo($pdo, $table);
    }

    /**
     * Get an instance of the Redis storage engine
     *
     * @param  LaravelConfig  $config
     * @return Redis
     */
    protected function selectStorageRedis($config)
    {
        $connection = $config->get('config.storage.connection');
        return new Redis($this->app['redis']->connection($connection));
    }

    /**
     * Get an instance of a custom defined storage engine
     *
     * @param  LaravelConfig $config [description]
     * @return StorageInterface
     */
    protected function selectStorageCustom($config)
    {
        $class = $config->get('config.storage.provider');
        return $this->app->make($class);
    }

    /**
     * Get an instance of the File storage engine
     *
     * @param  LaravelConfig $config
     * @return File
     */
    protected function selectStorageFile($config)
    {
        $path = $config->get('config.storage.path');
        return new File($path);
    }

    /**
     * Get an instance of the Elequent storage engine
     *
     * @param  LaravelConfig $config
     * @return Elequent Model
     */
    protected function selectStorageElequent($config)
    {
        $model = $config->get('config.storage.provider');        
        return new Elequent(new $model);
    }
}
