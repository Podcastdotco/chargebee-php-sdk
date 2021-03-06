<?php

namespace Tests;

use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\StreamFactoryDiscovery;
use Http\Mock\Client as MockClient;
use NathanDunn\Chargebee\Client;
use NathanDunn\Chargebee\HttpClient\Builder;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{
    /**
     * @var string
     */
    public static $key = '987654321';

    /**
     * @var string
     */
    public static $site = '123456789';

    /**
     * @var Builder
     */
    public $builder;

    /**
     * @var Client
     */
    public $client;

    /**
     * Set up test case.
     */
    public function setUp(): void
    {
        $this->builder = new Builder(
            self::$key, new MockClient(), MessageFactoryDiscovery::find(), StreamFactoryDiscovery::find()
        );
        $this->client = new Client(self::$site, self::$key, $this->builder);
    }
}
