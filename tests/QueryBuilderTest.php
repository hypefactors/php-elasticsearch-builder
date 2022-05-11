<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests;

use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\BoostingQuery;
use Hypefactors\ElasticBuilder\Query\Compound\BoostingQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\ConstantScoreQuery;
use Hypefactors\ElasticBuilder\Query\Compound\ConstantScoreQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\DisjunctionMaxQuery;
use Hypefactors\ElasticBuilder\Query\Compound\DisjunctionMaxQueryInterface;
use Hypefactors\ElasticBuilder\Query\MatchAllQuery;
use Hypefactors\ElasticBuilder\Query\MatchAllQueryInterface;
use Hypefactors\ElasticBuilder\Query\MatchNoneQuery;
use Hypefactors\ElasticBuilder\Query\MatchNoneQueryInterface;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQueryInterface;
use Hypefactors\ElasticBuilder\QueryBuilder;
use Hypefactors\ElasticBuilder\RequestBuilder;
use Hypefactors\ElasticBuilder\Tests\TestCase;
use stdClass;

class QueryBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function calling_to_array_without_any_queries_will_return_empty_result()
    {
        $queryBuilder = new QueryBuilder();

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [];

        $this->assertArrayHasKey('took', $response);
        $this->assertTrue($queryBuilder->isEmpty());
        $this->assertCount(0, $queryBuilder->getQueries());
        $this->assertSame($expected, $queryBuilder->build());
    }

    /**
     * @test
     */
    public function the_match_all_query_can_be_applied_using_a_class_instance()
    {
        $matchAll = new MatchAllQuery();

        $queryBuilder = new QueryBuilder();
        $queryBuilder->matchAll($matchAll);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'match_all' => new stdClass(),
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($queryBuilder->isEmpty());
        $this->assertCount(1, $queryBuilder->getQueries());
        $this->assertEquals($expected, $queryBuilder->build());
    }

    /**
     * @test
     */
    public function the_match_all_query_can_be_applied_using_a_closure()
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->matchAll(function (MatchAllQueryInterface $query) {
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'match_all' => new stdClass(),
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($queryBuilder->isEmpty());
        $this->assertCount(1, $queryBuilder->getQueries());
        $this->assertEquals($expected, $queryBuilder->build());
    }

    /**
     * @test
     */
    public function the_match_none_query_can_be_applied_using_a_class_instance()
    {
        $matchNone = new MatchNoneQuery();

        $queryBuilder = new QueryBuilder();
        $queryBuilder->matchNone($matchNone);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'match_none' => new stdClass(),
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($queryBuilder->isEmpty());
        $this->assertCount(1, $queryBuilder->getQueries());
        $this->assertEquals($expected, $queryBuilder->build());
    }

    /**
     * @test
     */
    public function the_match_none_query_can_be_applied_using_a_closure()
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->matchNone(function (MatchNoneQueryInterface $query) {
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'match_none' => new stdClass(),
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($queryBuilder->isEmpty());
        $this->assertCount(1, $queryBuilder->getQueries());
        $this->assertEquals($expected, $queryBuilder->build());
    }

    /**
     * @test
     */
    public function calling_to_array_with_an_empty_bool_query_will_return_empty_array()
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->bool(function (BoolQueryInterface $query) {
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [];

        $this->assertArrayHasKey('took', $response);
        $this->assertTrue($queryBuilder->isEmpty());
        $this->assertCount(0, $queryBuilder->getQueries());
        $this->assertSame($expected, $queryBuilder->build());
    }

    /**
     * @test
     */
    public function calling_to_array_with_an_empty_boosting_query_will_return_empty_array()
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->boosting(function (BoostingQueryInterface $query) {
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [];

        $this->assertArrayHasKey('took', $response);
        $this->assertTrue($queryBuilder->isEmpty());
        $this->assertCount(0, $queryBuilder->getQueries());
        $this->assertSame($expected, $queryBuilder->build());
    }

    /**
     * @test
     */
    public function calling_to_array_with_an_empty_constant_score_query_will_return_empty_array()
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->constantScore(function (ConstantScoreQueryInterface $query) {
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [];

        $this->assertArrayHasKey('took', $response);
        $this->assertTrue($queryBuilder->isEmpty());
        $this->assertCount(0, $queryBuilder->getQueries());
        $this->assertSame($expected, $queryBuilder->build());
    }

    /**
     * @test
     */
    public function calling_to_array_with_an_empty_disjunction_max_query_will_return_empty_array()
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->disjunctionMax(function (DisjunctionMaxQueryInterface $query) {
        });

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->query($queryBuilder);

        $response = $this->client->search($requestBuilder->build());

        $expected = [];

        $this->assertArrayHasKey('took', $response);
        $this->assertTrue($queryBuilder->isEmpty());
        $this->assertCount(0, $queryBuilder->getQueries());
        $this->assertSame($expected, $queryBuilder->build());
    }

    // /**
    //  * @test
    //  */
    // public function the_bool_query_can_be_applied_using_a_class_instance()
    // {
    //     $boolQuery = new BoolQuery();
    //     $boolQuery->filter(function (FilterQueryInterface $filterQuery) {
    //         $filterQuery->term(function (TermQueryInterface $termQuery) {
    //             $termQuery->field('name')->value('my-value');
    //         });
    //     });

    //     $queryBuilder = new QueryBuilder();
    //     $queryBuilder->bool($boolQuery);

    //     $requestBuilder = new RequestBuilder();
    //     $requestBuilder->index('ci-index');
    //     $requestBuilder->query($queryBuilder);

    //     $response = $this->client->search($requestBuilder->build());

    //     $expected = [
    //         'bool' => [
    //             'filter' => [
    //                 'term' => [
    //                     'name' => 'my-value',
    //                 ],
    //             ],
    //         ],
    //     ];

    //     $this->assertArrayHasKey('took', $response);
    //     $this->assertFalse($queryBuilder->isEmpty());
    //     $this->assertCount(1, $queryBuilder->getQueries());
    //     $this->assertSame($expected, $queryBuilder->build());
    // }

    // /**
    //  * @test
    //  */
    // public function the_bool_query_can_be_applied_using_a_closure()
    // {
    //     $queryBuilder = new QueryBuilder();
    //     $queryBuilder->bool(function (BoolQueryInterface $boolQuery) {
    //         $boolQuery->filter(function (FilterQueryInterface $filterQuery) {
    //             $filterQuery->term(function (TermQueryInterface $termQuery) {
    //                 $termQuery->field('name')->value('my-value');
    //             });
    //         });
    //     });

    //     $requestBuilder = new RequestBuilder();
    //     $requestBuilder->index('ci-index');
    //     $requestBuilder->query($queryBuilder);

    //     $response = $this->client->search($requestBuilder->build());

    //     $expected = [
    //         'bool' => [
    //             'filter' => [
    //                 'term' => [
    //                     'name' => 'my-value',
    //                 ],
    //             ],
    //         ],
    //     ];

    //     $this->assertArrayHasKey('took', $response);
    //     $this->assertFalse($queryBuilder->isEmpty());
    //     $this->assertCount(1, $queryBuilder->getQueries());
    //     $this->assertSame($expected, $queryBuilder->build());
    // }

    // /**
    //  * @test
    //  */
    // public function the_boosting_query_can_be_applied_using_a_class_instance()
    // {
    //     $termQuery = new TermQuery();
    //     $termQuery->field('name')->value('my-value');

    //     $boostingQuery = new BoostingQuery();
    //     $boostingQuery->positive($termQuery);
    //     $boostingQuery->negative($termQuery);
    //     $boostingQuery->negativeBoost(1.5);

    //     $queryBuilder = new QueryBuilder();
    //     $queryBuilder->boosting($boostingQuery);

    //     $requestBuilder = new RequestBuilder();
    //     $requestBuilder->index('ci-index');
    //     $requestBuilder->query($queryBuilder);

    //     $response = $this->client->search($requestBuilder->build());

    //     $expected = [
    //         'boosting' => [
    //             'positive' => [
    //                 'term' => [
    //                     'name' => 'my-value',
    //                 ],
    //             ],
    //             'negative' => [
    //                 'term' => [
    //                     'name' => 'my-value',
    //                 ],
    //             ],
    //             'negative_boost' => 1.5,
    //         ],
    //     ];

    //     $this->assertArrayHasKey('took', $response);
    //     $this->assertFalse($queryBuilder->isEmpty());
    //     $this->assertCount(1, $queryBuilder->getQueries());
    //     $this->assertSame($expected, $queryBuilder->build());
    // }

    // /**
    //  * @test
    //  */
    // public function the_boosting_query_can_be_applied_using_a_closure()
    // {
    //     $queryBuilder = new QueryBuilder();
    //     $queryBuilder->boosting(function (BoostingQueryInterface $boostingQuery) {
    //         $termQuery = new TermQuery();
    //         $termQuery->field('name')->value('my-value');

    //         $boostingQuery->positive($termQuery);
    //         $boostingQuery->negative($termQuery);
    //         $boostingQuery->negativeBoost(1.5);
    //     });

    //     $requestBuilder = new RequestBuilder();
    //     $requestBuilder->index('ci-index');
    //     $requestBuilder->query($queryBuilder);

    //     $response = $this->client->search($requestBuilder->build());

    //     $expected = [
    //         'boosting' => [
    //             'positive' => [
    //                 'term' => [
    //                     'name' => 'my-value',
    //                 ],
    //             ],
    //             'negative' => [
    //                 'term' => [
    //                     'name' => 'my-value',
    //                 ],
    //             ],
    //             'negative_boost' => 1.5,
    //         ],
    //     ];

    //     $this->assertArrayHasKey('took', $response);
    //     $this->assertFalse($queryBuilder->isEmpty());
    //     $this->assertCount(1, $queryBuilder->getQueries());
    //     $this->assertSame($expected, $queryBuilder->build());
    // }

    // /**
    //  * @test
    //  */
    // public function the_constant_score_query_can_be_applied_using_a_class_instance()
    // {
    //     $termQuery = new TermQuery();
    //     $termQuery->field('name')->value('my-value');

    //     $constantScoreQuery = new ConstantScoreQuery();
    //     $constantScoreQuery->filter($termQuery);

    //     $queryBuilder = new QueryBuilder();
    //     $queryBuilder->constantScore($constantScoreQuery);

    //     $requestBuilder = new RequestBuilder();
    //     $requestBuilder->index('ci-index');
    //     $requestBuilder->query($queryBuilder);

    //     $response = $this->client->search($requestBuilder->build());

    //     $expected = [
    //         'constant_score' => [
    //             'filter' => [
    //                 'term' => [
    //                     'name' => 'my-value',
    //                 ],
    //             ],
    //         ],
    //     ];

    //     $this->assertArrayHasKey('took', $response);
    //     $this->assertFalse($queryBuilder->isEmpty());
    //     $this->assertCount(1, $queryBuilder->getQueries());
    //     $this->assertSame($expected, $queryBuilder->build());
    // }

    // /**
    //  * @test
    //  */
    // public function the_constant_score_query_can_be_applied_using_a_closure()
    // {
    //     $queryBuilder = new QueryBuilder();
    //     $queryBuilder->constantScore(function (ConstantScoreQueryInterface $constantScoreQuery) {
    //         $termQuery = new TermQuery();
    //         $termQuery->field('name')->value('my-value');

    //         $constantScoreQuery->filter($termQuery);
    //     });

    //     $requestBuilder = new RequestBuilder();
    //     $requestBuilder->index('ci-index');
    //     $requestBuilder->query($queryBuilder);

    //     $response = $this->client->search($requestBuilder->build());

    //     $expected = [
    //         'constant_score' => [
    //             'filter' => [
    //                 'term' => [
    //                     'name' => 'my-value',
    //                 ],
    //             ],
    //         ],
    //     ];

    //     $this->assertArrayHasKey('took', $response);
    //     $this->assertFalse($queryBuilder->isEmpty());
    //     $this->assertCount(1, $queryBuilder->getQueries());
    //     $this->assertSame($expected, $queryBuilder->build());
    // }

    // /**
    //  * @test
    //  */
    // public function the_disjunction_max_query_can_be_applied_using_a_class_instance()
    // {
    //     $termQuery = new TermQuery();
    //     $termQuery->field('name')->value('my-value');

    //     $disjunctionMaxQuery = new DisjunctionMaxQuery();
    //     $disjunctionMaxQuery->query($termQuery);

    //     $queryBuilder = new QueryBuilder();
    //     $queryBuilder->disjunctionMax($disjunctionMaxQuery);

    //     $requestBuilder = new RequestBuilder();
    //     $requestBuilder->index('ci-index');
    //     $requestBuilder->query($queryBuilder);

    //     $response = $this->client->search($requestBuilder->build());

    //     $expected = [
    //         'dis_max' => [
    //             'queries' => [
    //                 [
    //                     'term' => [
    //                         'name' => 'my-value',
    //                     ],
    //                 ],
    //             ],
    //         ],
    //     ];

    //     $this->assertArrayHasKey('took', $response);
    //     $this->assertFalse($queryBuilder->isEmpty());
    //     $this->assertCount(1, $queryBuilder->getQueries());
    //     $this->assertSame($expected, $queryBuilder->build());
    // }

    // /**
    //  * @test
    //  */
    // public function the_disjunction_max_query_can_be_applied_using_a_closure()
    // {
    //     $queryBuilder = new QueryBuilder();
    //     $queryBuilder->disjunctionMax(function (DisjunctionMaxQueryInterface $disjunctionMaxQuery) {
    //         $termQuery = new TermQuery();
    //         $termQuery->field('name')->value('my-value');

    //         $disjunctionMaxQuery->query($termQuery);
    //     });

    //     $requestBuilder = new RequestBuilder();
    //     $requestBuilder->index('ci-index');
    //     $requestBuilder->query($queryBuilder);

    //     $response = $this->client->search($requestBuilder->build());

    //     $expected = [
    //         'dis_max' => [
    //             'queries' => [
    //                 [
    //                     'term' => [
    //                         'name' => 'my-value',
    //                     ],
    //                 ],
    //             ],
    //         ],
    //     ];

    //     $this->assertArrayHasKey('took', $response);
    //     $this->assertFalse($queryBuilder->isEmpty());
    //     $this->assertCount(1, $queryBuilder->getQueries());
    //     $this->assertSame($expected, $queryBuilder->build());
    // }
}
