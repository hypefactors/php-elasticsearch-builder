<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = ClientBuilder::create()
            ->setHosts(['localhost:9200'])
            ->build()
        ;
    }
}
