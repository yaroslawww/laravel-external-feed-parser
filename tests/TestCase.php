<?php

namespace ExternalFeedParser\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    use RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return [
            \ExternalFeedParser\ServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        $app['config']->set('external-feed-parser.jobs-feeds', [
            'xml_foo' => [
                'pull' => [
                    'class'   => \ExternalFeedParser\Pull\XmlFeedPull::class,
                    'options' => [
                        'url'        => 'https://www.test.com/foo.xml',
                        'listingKey' => 'baz.qux',
                    ],
                ],
                'convert' => [
                    'class'   => \ExternalFeedParser\Converters\SimpleConverter::class,
                    'options' => [
                        'entityClass' => \ExternalFeedParser\Entity\ExternalEntity::class,
                    ],
                ],
            ],
        ]);
    }
}
