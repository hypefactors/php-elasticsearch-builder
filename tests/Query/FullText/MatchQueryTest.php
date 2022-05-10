<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText;

use Hypefactors\ElasticBuilder\Query\FullText\MatchQuery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class MatchQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_query()
    {
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');

        $expected = [
            'match' => [
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
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->boost(1.5);

        $expected = [
            'match' => [
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
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->name('my-query-name');

        $expected = [
            'match' => [
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
    public function it_builds_the_query_with_the_cut_off_frequency_parameter()
    {
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->cutOffFrequency(0.001);

        $expected = [
            'match' => [
                'message' => [
                    'query'            => 'this is a test',
                    'cutoff_frequency' => 0.001,
                ],
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_fuziness_parameter()
    {
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->fuzziness(2);

        $expected = [
            'match' => [
                'message' => [
                    'query'     => 'this is a test',
                    'fuzziness' => 2,
                ],
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_lenient()
    {
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->lenient(true);

        $expected = [
            'match' => [
                'message' => [
                    'query'   => 'this is a test',
                    'lenient' => true,
                ],
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_max_expansinons_parameter()
    {
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->maxExpansions(5);

        $expected = [
            'match' => [
                'message' => [
                    'query'          => 'this is a test',
                    'max_expansions' => 5,
                ],
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_prefix_length_parameter()
    {
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->prefixLength(5);

        $expected = [
            'match' => [
                'message' => [
                    'query'         => 'this is a test',
                    'prefix_length' => 5,
                ],
            ],
        ];

        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function it_builds_the_query_with_the_operator()
    {
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->operator('and');

        $expected = [
            'match' => [
                'message' => [
                    'query'    => 'this is a test',
                    'operator' => 'and',
                ],
            ],
        ];
        $this->assertSame($expected, $query->build());
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_when_passing_an_invalid_operator()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The [foo] operator is invalid.');

        $query = new MatchQuery();
        $query->operator('foo');
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $query = new MatchQuery();
        $query->build();
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_if_the_query_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "query" is required!');

        $query = new MatchQuery();
        $query->field('message');

        $query->build();
    }
}
