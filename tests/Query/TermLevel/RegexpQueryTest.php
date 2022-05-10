<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\RegexpQuery;
use Hypefactors\ElasticBuilder\QueryBuilder;
use Hypefactors\ElasticBuilder\RequestBuilder;
use Hypefactors\ElasticBuilder\Tests\TestCase;
use InvalidArgumentException;

class RegexpQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $regexpQuery = new RegexpQuery();
        $regexpQuery->field('name.first');
        $regexpQuery->value('s.*');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($regexpQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($regexpQuery) {
                $query->regexp($regexpQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'regexp' => [
                'name.first' => 's.*',
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($regexpQuery->isEmpty());
        $this->assertSame($expected, $regexpQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_boost_factor_parameter()
    {
        $regexpQuery = new RegexpQuery();
        $regexpQuery->field('name.first');
        $regexpQuery->value('s.*');
        $regexpQuery->boost(1.5);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($regexpQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($regexpQuery) {
                $query->regexp($regexpQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'regexp' => [
                'name.first' => [
                    'value' => 's.*',
                    'boost' => 1.5,
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($regexpQuery->isEmpty());
        $this->assertSame($expected, $regexpQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_name_parameter()
    {
        $regexpQuery = new RegexpQuery();
        $regexpQuery->field('name.first');
        $regexpQuery->value('s.*');
        $regexpQuery->name('my-query-name');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($regexpQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($regexpQuery) {
                $query->regexp($regexpQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'regexp' => [
                'name.first' => [
                    'value' => 's.*',
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($regexpQuery->isEmpty());
        $this->assertSame($expected, $regexpQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_flags_parameter_from_a_string()
    {
        $regexpQuery = new RegexpQuery();
        $regexpQuery->field('name.first');
        $regexpQuery->value('s.*');
        $regexpQuery->flags('INTERSECTION|COMPLEMENT|EMPTY');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($regexpQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($regexpQuery) {
                $query->regexp($regexpQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'regexp' => [
                'name.first' => [
                    'value' => 's.*',
                    'flags' => 'INTERSECTION|COMPLEMENT|EMPTY',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($regexpQuery->isEmpty());
        $this->assertSame($expected, $regexpQuery->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_flags_parameter_from_an_array()
    {
        $regexpQuery = new RegexpQuery();
        $regexpQuery->field('name.first');
        $regexpQuery->value('s.*');
        $regexpQuery->flags(['INTERSECTION', 'COMPLEMENT', 'EMPTY']);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) use ($regexpQuery) {
            $query->filter(function (FilterQueryInterface $query) use ($regexpQuery) {
                $query->regexp($regexpQuery);
            });
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'regexp' => [
                'name.first' => [
                    'value' => 's.*',
                    'flags' => 'INTERSECTION|COMPLEMENT|EMPTY',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($regexpQuery->isEmpty());
        $this->assertSame($expected, $regexpQuery->build());
    }

    // /**
    //  * @test
    //  */
    // public function it_builds_the_query_with_the_max_determinized_states_parameter()
    // {
    //     $regexpQuery = new RegexpQuery();
    //     $regexpQuery->field('name.first');
    //     $regexpQuery->value('s.*');
    //     $regexpQuery->maxDeterminizedStates(5);

    //     $queryBuilder = new QueryBuilder();
    //     $queryBuilder->bool(function (BoolQueryInterface $query) use ($regexpQuery) {
    //         $query->filter(function (FilterQueryInterface $query) use ($regexpQuery) {
    //             $query->regexp($regexpQuery);
    //         });
    //     });

    //     $requestBuilder = new RequestBuilder();
    //     $requestBuilder->query($queryBuilder);

    //     $response = $this->client->search($requestBuilder->build());

    //     $expected = [
    //         'regexp' => [
    //             'name.first' => [
    //                 'value'                   => 's.*',
    //                 'max_determinized_states' => 5,
    //             ],
    //         ],
    //     ];

    //     $this->assertArrayHasKey('took', $response);
    //     $this->assertFalse($regexpQuery->isEmpty());
    //     $this->assertSame($expected, $regexpQuery->build());
    // }

    // /**
    //  * @test
    //  */
    // public function it_builds_the_query_with_the_rewrite_parameter()
    // {
    //     $regexpQuery = new RegexpQuery();
    //     $regexpQuery->field('name.first');
    //     $regexpQuery->value('s.*');
    //     $regexpQuery->rewrite('rewrite');

    //     $queryBuilder = new QueryBuilder();
    //     $queryBuilder->bool(function (BoolQueryInterface $query) use ($regexpQuery) {
    //         $query->filter(function (FilterQueryInterface $query) use ($regexpQuery) {
    //             $query->regexp($regexpQuery);
    //         });
    //     });

    //     $requestBuilder = new RequestBuilder();
    //     $requestBuilder->query($queryBuilder);

    //     $response = $this->client->search($requestBuilder->build());

    //     $expected = [
    //         'regexp' => [
    //             'name.first' => [
    //                 'value'   => 's.*',
    //                 'rewrite' => 'rewrite',
    //             ],
    //         ],
    //     ];

    //     $this->assertArrayHasKey('took', $response);
    //     $this->assertFalse($regexpQuery->isEmpty());
    //     $this->assertSame($expected, $regexpQuery->build());
    // }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_there_are_invalid_flags()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The given flags are invalid: FOO, BAR');

        $regexpQuery = new RegexpQuery();
        $regexpQuery->flags(['foo', 'COMPLEMENT', 'bAr']);
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $regexpQuery = new RegexpQuery();
        $regexpQuery->build();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_value_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "value" is required!');

        $regexpQuery = new RegexpQuery();
        $regexpQuery->field('name.first');

        $regexpQuery->build();
    }
}
