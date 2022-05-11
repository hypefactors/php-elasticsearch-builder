<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Core;

use Hypefactors\ElasticBuilder\Core\Collapse;
use Hypefactors\ElasticBuilder\Core\Highlight;
use Hypefactors\ElasticBuilder\Core\HighlightInterface;
use Hypefactors\ElasticBuilder\Core\InnerHits;
use Hypefactors\ElasticBuilder\Core\Script;
use Hypefactors\ElasticBuilder\Core\ScriptInterface;
use Hypefactors\ElasticBuilder\Core\Sort;
use Hypefactors\ElasticBuilder\Core\SortInterface;
use Hypefactors\ElasticBuilder\RequestBuilder;
use Hypefactors\ElasticBuilder\Tests\TestCase;
use stdClass;

class InnerHitsTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_set_the_from_property_as_an_integer()
    {
        $innerHits = new InnerHits();
        $innerHits->from(1);

        $collapseQuery = new Collapse();
        $collapseQuery->field('name');
        $collapseQuery->innerHits($innerHits);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->collapse($collapseQuery);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'from' => 1,
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($innerHits->isEmpty());
        $this->assertEquals($expected, $innerHits->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_from_property_as_a_string()
    {
        $innerHits = new InnerHits();
        $innerHits->from(1);

        $collapseQuery = new Collapse();
        $collapseQuery->field('name');
        $collapseQuery->innerHits($innerHits);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->collapse($collapseQuery);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'from' => '1',
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($innerHits->isEmpty());
        $this->assertEquals($expected, $innerHits->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_size_property_as_an_integer()
    {
        $innerHits = new InnerHits();
        $innerHits->size(1);

        $collapseQuery = new Collapse();
        $collapseQuery->field('name');
        $collapseQuery->innerHits($innerHits);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->collapse($collapseQuery);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'size' => 1,
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($innerHits->isEmpty());
        $this->assertEquals($expected, $innerHits->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_size_property_as_a_string()
    {
        $innerHits = new InnerHits();
        $innerHits->size(1);

        $collapseQuery = new Collapse();
        $collapseQuery->field('name');
        $collapseQuery->innerHits($innerHits);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->collapse($collapseQuery);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'size' => '1',
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($innerHits->isEmpty());
        $this->assertEquals($expected, $innerHits->build());
    }

    /**
     * @test
     */
    public function it_can_apply_a_sort_as_a_callable()
    {
        $innerHits = new InnerHits();
        $innerHits->sort(function (SortInterface $sort) {
            $sort->field('name');
            $sort->order('asc');
        });
        $innerHits->sort(function (SortInterface $sort) {
            $sort->field('programming_languages');
            $sort->order('desc');
        });

        $collapseQuery = new Collapse();
        $collapseQuery->field('name');
        $collapseQuery->innerHits($innerHits);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->collapse($collapseQuery);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'sort' => [
                ['name' => 'asc'],
                ['programming_languages' => 'desc'],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($innerHits->isEmpty());
        $this->assertEquals($expected, $innerHits->build());
    }

    /**
     * @test
     */
    public function it_can_apply_a_sort_using_a_sort_object()
    {
        $sort1 = new Sort();
        $sort1->field('name');
        $sort1->order('asc');

        $sort2 = new Sort();
        $sort2->field('programming_languages');
        $sort2->order('desc');

        $innerHits = new InnerHits();
        $innerHits->sort($sort1);
        $innerHits->sort($sort2);

        $collapseQuery = new Collapse();
        $collapseQuery->field('name');
        $collapseQuery->innerHits($innerHits);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->collapse($collapseQuery);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'sort' => [
                ['name' => 'asc'],
                ['programming_languages' => 'desc'],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($innerHits->isEmpty());
        $this->assertEquals($expected, $innerHits->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_name_property()
    {
        $innerHits = new InnerHits();
        $innerHits->name('Some Name');

        $collapseQuery = new Collapse();
        $collapseQuery->field('name');
        $collapseQuery->innerHits($innerHits);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->collapse($collapseQuery);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'name' => 'Some Name',
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($innerHits->isEmpty());
        $this->assertEquals($expected, $innerHits->build());
    }

    /**
     * @test
     */
    public function it_can_apply_a_highlight_as_a_callable()
    {
        $innerHits = new InnerHits();
        $innerHits->highlight(function (HighlightInterface $highlight) {
            $highlight->field('name');
        });

        $collapseQuery = new Collapse();
        $collapseQuery->field('name');
        $collapseQuery->innerHits($innerHits);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->collapse($collapseQuery);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'highlight' => [
                'fields' => [
                    'name' => new stdClass(),
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($innerHits->isEmpty());
        $this->assertEquals($expected, $innerHits->build());
    }

    /**
     * @test
     */
    public function it_can_apply_a_highlight_using_a_sort_object()
    {
        $highlight = new Highlight();
        $highlight->field('name');

        $innerHits = new InnerHits();
        $innerHits->highlight($highlight);

        $collapseQuery = new Collapse();
        $collapseQuery->field('name');
        $collapseQuery->innerHits($innerHits);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->collapse($collapseQuery);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'highlight' => [
                'fields' => [
                    'name' => new stdClass(),
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($innerHits->isEmpty());
        $this->assertEquals($expected, $innerHits->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_explain_property()
    {
        $innerHits = new InnerHits();
        $innerHits->explain(true);

        $collapseQuery = new Collapse();
        $collapseQuery->field('name');
        $collapseQuery->innerHits($innerHits);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->collapse($collapseQuery);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'explain' => true,
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($innerHits->isEmpty());
        $this->assertEquals($expected, $innerHits->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_source_property_using_a_boolean()
    {
        $innerHits = new InnerHits();
        $innerHits->source(false);

        $collapseQuery = new Collapse();
        $collapseQuery->field('name');
        $collapseQuery->innerHits($innerHits);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->collapse($collapseQuery);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            '_source' => false,
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($innerHits->isEmpty());
        $this->assertEquals($expected, $innerHits->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_source_property_using_a_string()
    {
        $innerHits = new InnerHits();
        $innerHits->source('some-field');

        $collapseQuery = new Collapse();
        $collapseQuery->field('name');
        $collapseQuery->innerHits($innerHits);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->collapse($collapseQuery);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            '_source' => 'some-field',
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($innerHits->isEmpty());
        $this->assertEquals($expected, $innerHits->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_source_property_using_an_array()
    {
        $innerHits = new InnerHits();
        $innerHits->source([
            'field-one',
            'field-two',
        ]);

        $collapseQuery = new Collapse();
        $collapseQuery->field('name');
        $collapseQuery->innerHits($innerHits);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->collapse($collapseQuery);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            '_source' => [
                'field-one',
                'field-two',
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($innerHits->isEmpty());
        $this->assertEquals($expected, $innerHits->build());
    }

    // /**
    //  * @test
    //  */
    // public function it_can_apply_a_script_as_a_callable()
    // {
    //     $innerHits = new InnerHits();
    //     $innerHits->script(function (ScriptInterface $script) {
    //         $script->source('name');
    //     });

    //     $collapseQuery = new Collapse();
    //     $collapseQuery->field('name');
    //     $collapseQuery->innerHits($innerHits);

    //     $builder = (new RequestBuilder())
    //         ->collapse($collapseQuery);
    //     ;

    //     $response = $this->client->search($requestBuilder->build());

    //     $expected = [
    //         'script_fields' => [
    //             [
    //                 'source' => 'name',
    //             ],
    //         ],
    //     ];

    //     $this->assertArrayHasKey('took', $response);
    //     $this->assertEquals($expected, $innerHits->build());
    // }

    // /**
    //  * @test
    //  */
    // public function it_can_apply_a_script_using_a_sort_object()
    // {
    //     $script = new Script();
    //     $script->source('name');

    //     $innerHits = new InnerHits();
    //     $innerHits->script($script);

    //     $collapseQuery = new Collapse();
    //     $collapseQuery->field('name');
    //     $collapseQuery->innerHits($innerHits);

    //     $builder = (new RequestBuilder())
    //         ->collapse($collapseQuery);
    //     ;

    //     $response = $this->client->search($requestBuilder->build());

    //     $expected = [
    //         'script_fields' => [
    //             [
    //                 'source' => 'name',
    //             ],
    //         ],
    //     ];

    //     $this->assertArrayHasKey('took', $response);
    //     $this->assertEquals($expected, $innerHits->build());
    // }

    /**
     * @test
     */
    public function it_can_set_a_docvalue_field()
    {
        $innerHits = new InnerHits();
        $innerHits->docValueField('name');
        $innerHits->docValueField('programming_languages', 'epoch_millis');

        $collapseQuery = new Collapse();
        $collapseQuery->field('name');
        $collapseQuery->innerHits($innerHits);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->collapse($collapseQuery);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'docvalue_fields' => [
                'name',
                [
                    'field'  => 'programming_languages',
                    'format' => 'epoch_millis',
                ],
            ],
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($innerHits->isEmpty());
        $this->assertEquals($expected, $innerHits->build());
    }

    /**
     * @test
     */
    public function it_can_set_the_version_property()
    {
        $innerHits = new InnerHits();
        $innerHits->version(true);

        $collapseQuery = new Collapse();
        $collapseQuery->field('name');
        $collapseQuery->innerHits($innerHits);

        $requestBuilder = new RequestBuilder();
        $requestBuilder->index('ci-index');
        $requestBuilder->collapse($collapseQuery);

        $response = $this->client->search($requestBuilder->build());

        $expected = [
            'version' => true,
        ];

        $this->assertArrayHasKey('took', $response);
        $this->assertFalse($innerHits->isEmpty());
        $this->assertEquals($expected, $innerHits->build());
    }
}
