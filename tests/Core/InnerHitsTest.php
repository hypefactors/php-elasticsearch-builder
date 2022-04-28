<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Tests\Core;

use Hypefactors\ElasticBuilder\Core\InnerHits;
use Hypefactors\ElasticBuilder\Core\Sort;
use Hypefactors\ElasticBuilder\Core\SortInterface;
use Hypefactors\ElasticBuilder\Core\Highlight;
use Hypefactors\ElasticBuilder\Core\HighlightInterface;
use Hypefactors\ElasticBuilder\Core\Script;
use Hypefactors\ElasticBuilder\Core\ScriptInterface;
use PHPUnit\Framework\TestCase;
use stdClass;

class InnerHitsTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_return_empty_body()
    {
        $innerHits = new InnerHits();

        $expectedArray = [];

        $expectedJson = <<<'JSON'
            []
            JSON;

        $this->assertEquals($expectedArray, $innerHits->toArray());
        $this->assertSame($expectedJson, $innerHits->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_from_property_as_an_integer()
    {
        $innerHits = new InnerHits();
        $innerHits->from(1);

        $expectedArray = [
            'from' => 1
        ];

        $expectedJson = <<<'JSON'
            {
                "from": 1
            }
            JSON;

        $this->assertEquals($expectedArray, $innerHits->toArray());
        $this->assertSame($expectedJson, $innerHits->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_from_property_as_a_string()
    {
        $innerHits = new InnerHits();
        $innerHits->from(1);

        $expectedArray = [
            'from' => '1'
        ];

        $expectedJson = <<<'JSON'
            {
                "from": 1
            }
            JSON;

        $this->assertEquals($expectedArray, $innerHits->toArray());
        $this->assertSame($expectedJson, $innerHits->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_size_property_as_an_integer()
    {
        $innerHits = new InnerHits();
        $innerHits->size(1);

        $expectedArray = [
            'size' => 1
        ];

        $expectedJson = <<<'JSON'
            {
                "size": 1
            }
            JSON;

        $this->assertEquals($expectedArray, $innerHits->toArray());
        $this->assertSame($expectedJson, $innerHits->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_size_property_as_a_string()
    {
        $innerHits = new InnerHits();
        $innerHits->size(1);

        $expectedArray = [
            'size' => '1'
        ];

        $expectedJson = <<<'JSON'
            {
                "size": 1
            }
            JSON;

        $this->assertEquals($expectedArray, $innerHits->toArray());
        $this->assertSame($expectedJson, $innerHits->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_apply_a_sort_as_a_callable()
    {
        $innerHits = new InnerHits();
        $innerHits->sort(function (SortInterface $sort) {
            $sort->field('my-field-1');
            $sort->order('asc');
        });
        $innerHits->sort(function (SortInterface $sort) {
            $sort->field('my-field-2');
            $sort->order('desc');
        });

        $expectedArray = [
            'sort' => [
                ['my-field-1' => 'asc'],
                ['my-field-2' => 'desc'],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "sort": [
                    {
                        "my-field-1": "asc"
                    },
                    {
                        "my-field-2": "desc"
                    }
                ]
            }
            JSON;

        $this->assertEquals($expectedArray, $innerHits->toArray());
        $this->assertSame($expectedJson, $innerHits->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_apply_a_sort_using_a_sort_object()
    {
        $sort1 = new Sort();
        $sort1->field('my-field-1');
        $sort1->order('asc');

        $sort2 = new Sort();
        $sort2->field('my-field-2');
        $sort2->order('desc');

        $innerHits = new InnerHits();
        $innerHits->sort($sort1);
        $innerHits->sort($sort2);

        $expectedArray = [
            'sort' => [
                ['my-field-1' => 'asc'],
                ['my-field-2' => 'desc'],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "sort": [
                    {
                        "my-field-1": "asc"
                    },
                    {
                        "my-field-2": "desc"
                    }
                ]
            }
            JSON;

        $this->assertEquals($expectedArray, $innerHits->toArray());
        $this->assertSame($expectedJson, $innerHits->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_name_property()
    {
        $innerHits = new InnerHits();
        $innerHits->name('Some Name');

        $expectedArray = [
            'name' => 'Some Name',
        ];

        $expectedJson = <<<'JSON'
            {
                "name": "Some Name"
            }
            JSON;

        $this->assertEquals($expectedArray, $innerHits->toArray());
        $this->assertSame($expectedJson, $innerHits->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_apply_a_highlight_as_a_callable()
    {
        $innerHits = new InnerHits();
        $innerHits->highlight(function (HighlightInterface $highlight) {
            $highlight->field('my-field');
        });

        $expectedArray = [
            'highlight' => [
                'fields' => [
                    'my-field' => new stdClass(),
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "highlight": {
                    "fields": {
                        "my-field": {}
                    }
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $innerHits->toArray());
        $this->assertSame($expectedJson, $innerHits->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_apply_a_highlight_using_a_sort_object()
    {
        $highlight = new Highlight();
        $highlight->field('my-field');

        $innerHits = new InnerHits();
        $innerHits->highlight($highlight);

        $expectedArray = [
            'highlight' => [
                'fields' => [
                    'my-field' => new stdClass(),
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "highlight": {
                    "fields": {
                        "my-field": {}
                    }
                }
            }
            JSON;

        $this->assertEquals($expectedArray, $innerHits->toArray());
        $this->assertSame($expectedJson, $innerHits->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_explain_property()
    {
        $innerHits = new InnerHits();
        $innerHits->explain(true);

        $expectedArray = [
            'explain' => true,
        ];

        $expectedJson = <<<'JSON'
            {
                "explain": true
            }
            JSON;

        $this->assertEquals($expectedArray, $innerHits->toArray());
        $this->assertSame($expectedJson, $innerHits->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_source_property_using_a_boolean()
    {
        $innerHits = new InnerHits();
        $innerHits->source(false);

        $expectedArray = [
            '_source' => false,
        ];

        $expectedJson = <<<'JSON'
            {
                "_source": false
            }
            JSON;

        $this->assertEquals($expectedArray, $innerHits->toArray());
        $this->assertSame($expectedJson, $innerHits->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_the_source_property_using_a_string()
    {
        $innerHits = new InnerHits();
        $innerHits->source('some-field');

        $expectedArray = [
            '_source' => 'some-field',
        ];

        $expectedJson = <<<'JSON'
            {
                "_source": "some-field"
            }
            JSON;

        $this->assertEquals($expectedArray, $innerHits->toArray());
        $this->assertSame($expectedJson, $innerHits->toJson(JSON_PRETTY_PRINT));
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

        $expectedArray = [
            '_source' => [
                'field-one',
                'field-two',
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "_source": [
                    "field-one",
                    "field-two"
                ]
            }
            JSON;

        $this->assertEquals($expectedArray, $innerHits->toArray());
        $this->assertSame($expectedJson, $innerHits->toJson(JSON_PRETTY_PRINT));
    }
    /**
     * @test
     */
    public function it_can_apply_a_script_as_a_callable()
    {
        $innerHits = new InnerHits();
        $innerHits->script(function (ScriptInterface $script) {
            $script->source('my-field');
        });

        $expectedArray = [
            'script_fields' => [
                [
                    'source' => 'my-field',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "script_fields": [
                    {
                        "source": "my-field"
                    }
                ]
            }
            JSON;

        $this->assertEquals($expectedArray, $innerHits->toArray());
        $this->assertSame($expectedJson, $innerHits->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_apply_a_script_using_a_sort_object()
    {
        $script = new Script();
        $script->source('my-field');

        $innerHits = new InnerHits();
        $innerHits->script($script);

        $expectedArray = [
            'script_fields' => [
                [
                    'source' => 'my-field',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "script_fields": [
                    {
                        "source": "my-field"
                    }
                ]
            }
            JSON;

        $this->assertEquals($expectedArray, $innerHits->toArray());
        $this->assertSame($expectedJson, $innerHits->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * @test
     */
    public function it_can_set_a_docvalue_field()
    {
        $innerHits = new InnerHits();
        $innerHits->docValueField('my-field-1');
        $innerHits->docValueField('my-field-2', 'epoch_millis');

        $expectedArray = [
            'docvalue_fields' => [
                'my-field-1',
                [
                    'field'  => 'my-field-2',
                    'format' => 'epoch_millis',
                ],
            ],
        ];

        $expectedJson = <<<'JSON'
            {
                "docvalue_fields": [
                    "my-field-1",
                    {
                        "field": "my-field-2",
                        "format": "epoch_millis"
                    }
                ]
            }
            JSON;

        $this->assertEquals($expectedArray, $innerHits->toArray());
        $this->assertSame($expectedJson, $innerHits->toJson(JSON_PRETTY_PRINT));
    }


    /**
     * @test
     */
    public function it_can_set_the_version_property()
    {
        $innerHits = new InnerHits();
        $innerHits->version(true);

        $expectedArray = [
            'version' => true,
        ];

        $expectedJson = <<<'JSON'
            {
                "version": true
            }
            JSON;

        $this->assertEquals($expectedArray, $innerHits->toArray());
        $this->assertSame($expectedJson, $innerHits->toJson(JSON_PRETTY_PRINT));
    }
}
