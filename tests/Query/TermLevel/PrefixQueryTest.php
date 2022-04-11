<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\TermLevel\PrefixQuery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PrefixQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $query = new PrefixQuery();
        $query->field('user');
        $query->value('ki');

        $expectedArray = [
            'prefix' => [
                'user' => 'ki',
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "prefix": {
                    "user": "ki"
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_boost_factor_parameter()
    {
        $query = new PrefixQuery();
        $query->field('user');
        $query->value('ki');
        $query->boost(1.5);

        $expectedArray = [
            'prefix' => [
                'user' => [
                    'value' => 'ki',
                    'boost' => 1.5,
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "prefix": {
                    "user": {
                        "value": "ki",
                        "boost": 1.5
                    }
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_name_parameter()
    {
        $query = new PrefixQuery();
        $query->field('user');
        $query->value('ki');
        $query->name('my-query-name');

        $expectedArray = [
            'prefix' => [
                'user' => [
                    'value' => 'ki',
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "prefix": {
                    "user": {
                        "value": "ki",
                        "_name": "my-query-name"
                    }
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_rewrite_parameter()
    {
        $query = new PrefixQuery();
        $query->field('user');
        $query->value('ki');
        $query->rewrite('rewrite');

        $expectedArray = [
            'prefix' => [
                'user' => [
                    'value'   => 'ki',
                    'rewrite' => 'rewrite',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "prefix": {
                    "user": {
                        "value": "ki",
                        "rewrite": "rewrite"
                    }
                }
            }
            JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function exception_will_be_thrown_if_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $query = new PrefixQuery();
        $query->toArray();
    }

    /**
     * @test
     */
    public function exception_will_be_thrown_if_value_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "value" is required!');

        $query = new PrefixQuery();
        $query->field('user');

        $query->toArray();
    }
}
