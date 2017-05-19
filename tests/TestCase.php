<?php

class TestCase extends Orchestra\Testbench\TestCase
{
    /**
     * Get application providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getApplicationProviders($app)
    {
        $providers = parent::getApplicationProviders($app);

        unset($providers[array_search('Illuminate\Auth\Passwords\PasswordResetServiceProvider', $providers)]);

        return $providers;
    }

    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            Robsonvn\CouchDB\ServiceProvider::class,
            //Jenssegers\Mongodb\Auth\PasswordResetServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // reset base path to point to our package's src directory
        //$app['path.base'] = __DIR__ . '/../src';

        $config = require 'config/database.php';

        $app['config']->set('app.key', 'ZsZewWyUJ5FsKp9lMwv4tYbNlegQilM7');

        $app['config']->set('database.default', 'couchdb');
        $app['config']->set('database.connections.mysql', $config['connections']['mysql']);
        $app['config']->set('database.connections.couchdb', $config['connections']['couchdb']);

        $app['config']->set('auth.model', 'User');
        $app['config']->set('auth.providers.users.model', 'User');
        $app['config']->set('cache.driver', 'array');

        $app['config']->set('queue.default', 'database');
        $app['config']->set('queue.connections.database', [
            'driver' => 'couchdb',
            'table'  => 'jobs',
            'queue'  => 'default',
            'expire' => 60,
        ]);
    }
}