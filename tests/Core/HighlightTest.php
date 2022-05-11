<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Core;

use Hypefactors\ElasticBuilder\Core\Highlight;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\MustQuery;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\ShouldQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\ExistsQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQuery;
use Hypefactors\ElasticBuilder\RequestBuilder;
use Hypefactors\ElasticBuilder\Tests\TestCase;
use InvalidArgumentException;
use stdClass;

class HighlightTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_set_the_boundary_chars_globally()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->field('programming_languages');
        $highlight->boundaryChars('.,!?');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'boundary_chars' => '.,!?',
            'fields'         => [
                'name' => new stdClass(),
                'programming_languages' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_boundary_chars_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->field('programming_languages');
        $highlight->boundaryChars('.,!?', 'name');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fields' => [
                'name' => [
                    'boundary_chars' => '.,!?',
                ],
                'programming_languages' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_boundary_max_scan_globally()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->field('programming_languages');
        $highlight->boundaryMaxScan(5);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'boundary_max_scan' => 5,
            'fields'            => [
                'name' => new stdClass(),
                'programming_languages' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_boundary_max_scan_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->field('programming_languages');
        $highlight->boundaryMaxScan(5, 'name');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fields' => [
                'name' => [
                    'boundary_max_scan' => 5,
                ],
                'programming_languages' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_boundary_scanner_globally()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->field('programming_languages');
        $highlight->boundaryScanner('chars');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'boundary_scanner' => 'chars',
            'fields'           => [
                'name' => new stdClass(),
                'programming_languages' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_boundary_scanner_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->field('programming_languages');
        $highlight->boundaryScanner('chars', 'name');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fields' => [
                'name' => [
                    'boundary_scanner' => 'chars',
                ],
                'programming_languages' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_boundary_scanner_locale_globally()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->field('programming_languages');
        $highlight->boundaryScannerLocale('en-US');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'boundary_scanner_locale' => 'en-US',
            'fields'                  => [
                'name' => new stdClass(),
                'programming_languages' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_boundary_scanner_locale_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->field('programming_languages');
        $highlight->boundaryScannerLocale('en-US', 'name');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fields' => [
                'name' => [
                    'boundary_scanner_locale' => 'en-US',
                ],
                'programming_languages' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_encoder()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->field('programming_languages');
        $highlight->encoder('html');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'encoder' => 'html',
            'fields'  => [
                'name' => new stdClass(),
                'programming_languages' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_a_single_field()
    {
        $highlight = new Highlight();
        $highlight->field('name');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fields' => [
                'name' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_multiple_fields()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->field('programming_languages');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fields' => [
                'name' => new stdClass(),
                'programming_languages' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_multiple_fields_from_an_array()
    {
        $highlight = new Highlight();
        $highlight->fields([
            'name' => (new Highlight())->numberOfFragments(1),
            'programming_languages',
        ]);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fields' => [
                'name' => [
                    'number_of_fragments' => 1,
                ],
                'programming_languages' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_force_source_globally()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->field('programming_languages');
        $highlight->forceSource(true);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'force_source' => true,
            'fields'       => [
                'name' => new stdClass(),
                'programming_languages' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_force_source_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->field('programming_languages');
        $highlight->forceSource(true, 'name');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fields' => [
                'name' => [
                    'force_source' => true,
                ],
                'programming_languages' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_fragmenter_globally()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->field('programming_languages');
        $highlight->fragmenter('simple');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fragmenter' => 'simple',
            'fields'     => [
                'name' => new stdClass(),
                'programming_languages' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_fragmenter_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->field('programming_languages');
        $highlight->fragmenter('simple', 'name');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fields' => [
                'name' => [
                    'fragmenter' => 'simple',
                ],
                'programming_languages' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_fragment_offset_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->field('programming_languages');
        $highlight->fragmentOffset(1, 'name');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fields' => [
                'name' => [
                    'type'            => 'fvh',
                    'fragment_offset' => 1,
                ],
                'programming_languages' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_fragment_size_globally()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->fragmentSize(1);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fragment_size' => 1,
            'fields'        => [
                'name' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_fragment_size_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->field('programming_languages');
        $highlight->fragmentSize(1, 'name');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fields' => [
                'name' => [
                    'fragment_size' => 1,
                ],
                'programming_languages' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_highlight_query_globally()
    {
        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $mustQuery = new MustQuery();
        $mustQuery->term($termQuery);

        $existsQuery = new ExistsQuery();
        $existsQuery->field('user');

        $shouldQuery = new ShouldQuery();
        $shouldQuery->exists($existsQuery);

        $boolQuery = new BoolQuery();
        $boolQuery->must($mustQuery);
        $boolQuery->should($shouldQuery);
        $boolQuery->minimumShouldMatch(0);

        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->highlightQuery($boolQuery);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'highlight_query' => [
                'bool' => [
                    'minimum_should_match' => 0,
                    'must'                 => [
                        'term' => [
                            'user' => 'john',
                        ],
                    ],
                    'should' => [
                        'exists' => [
                            'field' => 'user',
                        ],
                    ],
                ],
            ],
            'fields' => [
                'name' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_highlight_query_on_a_field()
    {
        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $mustQuery = new MustQuery();
        $mustQuery->term($termQuery);

        $existsQuery = new ExistsQuery();
        $existsQuery->field('user');

        $shouldQuery = new ShouldQuery();
        $shouldQuery->exists($existsQuery);

        $boolQuery = new BoolQuery();
        $boolQuery->must($mustQuery);
        $boolQuery->should($shouldQuery);
        $boolQuery->minimumShouldMatch(0);

        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->highlightQuery($boolQuery, 'name');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fields' => [
                'name' => [
                    'highlight_query' => [
                        'bool' => [
                            'minimum_should_match' => 0,
                            'must'                 => [
                                'term' => [
                                    'user' => 'john',
                                ],
                            ],
                            'should' => [
                                'exists' => [
                                    'field' => 'user',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertSame($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_matched_fields_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->field('programming_languages');
        $highlight->matchedFields(['something'], 'name');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fields' => [
                'name' => [
                    'type'           => 'fvh',
                    'matched_fields' => [
                        'something',
                    ],
                ],
                'programming_languages' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_no_match_size_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->field('programming_languages');
        $highlight->noMatchSize(1, 'name');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fields' => [
                'name' => [
                    'no_match_size' => 1,
                ],
                'programming_languages' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_number_of_fragments_globally()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->numberOfFragments(1);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'number_of_fragments' => 1,
            'fields'              => [
                'name' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_number_of_fragments_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->field('programming_languages');
        $highlight->numberOfFragments(1, 'name');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fields' => [
                'name' => [
                    'number_of_fragments' => 1,
                ],
                'programming_languages' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_score_order_globally()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->scoreOrder();

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'order'  => 'score',
            'fields' => [
                'name' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_score_order_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->field('programming_languages');
        $highlight->scoreOrder('name');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fields' => [
                'name' => [
                    'order' => 'score',
                ],
                'programming_languages' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_phrase_limit()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->field('programming_languages');
        $highlight->phraseLimit(10);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'phrase_limit' => 10,
            'fields'       => [
                'name' => new stdClass(),
                'programming_languages' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_pre_and_post_tags_globally()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->preTags('<em>');
        $highlight->postTags('</em>');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'pre_tags' => [
                '<em>',
            ],
            'post_tags' => [
                '</em>',
            ],
            'fields' => [
                'name' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_pre_and_post_tags_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->preTags('<em>', 'name');
        $highlight->postTags('</em>', 'name');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fields' => [
                'name' => [
                    'pre_tags' => [
                        '<em>',
                    ],
                    'post_tags' => [
                        '</em>',
                    ],
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertSame($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_require_field_match_globally()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->field('programming_languages');
        $highlight->requireFieldMatch(true);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'require_field_match' => true,
            'fields'              => [
                'name' => new stdClass(),
                'programming_languages' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_require_field_match_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->field('programming_languages');
        $highlight->requireFieldMatch(true, 'name');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fields' => [
                'name' => [
                    'require_field_match' => true,
                ],
                'programming_languages' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_tags_schema_as_styled()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->tagsSchema();

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'tags_schema' => 'styled',
            'fields'      => [
                'name' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_type_globally()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->field('programming_languages');
        $highlight->type('plain');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'type'   => 'plain',
            'fields' => [
                'name' => new stdClass(),
                'programming_languages' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_type_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('name');
        $highlight->field('programming_languages');
        $highlight->type('plain', 'name');

        $requestBuilder = new RequestBuilder();
        $requestBuilder->highlight($highlight);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'fields' => [
                'name' => [
                    'type' => 'plain',
                ],
                'programming_languages' => new stdClass(),
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($highlight->isEmpty());
        $this->assertEquals($expected, $highlight->build());
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_when_setting_an_invalid_boundary_scanner()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The [foo] boundary scanner is invalid!');

        $highlight = new Highlight();
        $highlight->boundaryScanner('foo');
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_when_setting_an_invalid_encoder()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The [foo] encoder is invalid!');

        $highlight = new Highlight();
        $highlight->encoder('foo');
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_when_setting_an_invalid_type()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The [foo] type is invalid!');

        $highlight = new Highlight();
        $highlight->type('foo');
    }

    /**
     * @test
     */
    public function an_exception_will_be_thrown_when_setting_an_invalid_fragmenter()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The [foo] fragmenter is invalid!');

        $highlight = new Highlight();
        $highlight->fragmenter('foo');
    }
}
