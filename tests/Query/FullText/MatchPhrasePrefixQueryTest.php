<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText;

use Hypefactors\ElasticBuilder\Query\FullText\MatchPhrasePrefixQuery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class MatchPhrasePrefixQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $query = new MatchPhrasePrefixQuery();
        $query->field('message');
        $query->query('this is a test');

        $expected = [
            'match_phrase_prefix' => [
                'message' => 'this is a test',
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_boost_factor_parameter()
    {
        $query = new MatchPhrasePrefixQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->boost(1.5);

        $expected = [
            'match_phrase_prefix' => [
                'message' => [
                    'query' => 'this is a test',
                    'boost' => 1.5,
                ],
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_name_parameter()
    {
        $query = new MatchPhrasePrefixQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->name('my-query-name');

        $expected = [
            'match_phrase_prefix' => [
                'message' => [
                    'query' => 'this is a test',
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_analyzer_parameter()
    {
        $query = new MatchPhrasePrefixQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->analyzer('something');

        $expected = [
            'match_phrase_prefix' => [
                'message' => [
                    'query'    => 'this is a test',
                    'analyzer' => 'something',
                ],
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_max_expansions_parameter()
    {
        $query = new MatchPhrasePrefixQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->maxExpansions(10);

        $expected = [
            'match_phrase_prefix' => [
                'message' => [
                    'query'          => 'this is a test',
                    'max_expansions' => 10,
                ],
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_slop_parameter()
    {
        $query = new MatchPhrasePrefixQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->slop(10);

        $expected = [
            'match_phrase_prefix' => [
                'message' => [
                    'query' => 'this is a test',
                    'slop'  => 10,
                ],
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_zero_terms_query_parameter()
    {
        $query = new MatchPhrasePrefixQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->zeroTermsQuery('all');

        $expected = [
            'match_phrase_prefix' => [
                'message' => [
                    'query'            => 'this is a test',
                    'zero_terms_query' => 'all',
                ],
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_when_setting_an_invalid_zero_terms_query_status()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The [foo] zero terms query status is invalid!');

        $query = new MatchPhrasePrefixQuery();
        $query->field('message');
        $query->zeroTermsQuery('foo');
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $query = new MatchPhrasePrefixQuery();
        $query->build();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_query_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "query" is required!');

        $query = new MatchPhrasePrefixQuery();
        $query->field('message');

        $query->build();
    }
}
