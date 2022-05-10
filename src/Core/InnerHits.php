<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Core;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/inner-hits.html
 */
class InnerHits implements InnerHitsInterface
{
    private array $body = [];

    public function from(int | string $from): InnerHitsInterface
    {
        $this->body['from'] = $from;

        return $this;
    }

    public function size(int | string $size): InnerHitsInterface
    {
        $this->body['size'] = $size;

        return $this;
    }

    public function sort(callable | SortInterface $value): InnerHitsInterface
    {
        if (is_callable($value)) {
            $sort = new Sort();

            $value($sort);

            return $this->sort($sort);
        }

        $this->body['sort'][] = $value;

        return $this;
    }

    public function name(string $name): InnerHitsInterface
    {
        $this->body['name'] = $name;

        return $this;
    }

    public function highlight(callable | HighlightInterface $value): InnerHitsInterface
    {
        if (is_callable($value)) {
            $highlight = new Highlight();

            $value($highlight);

            return $this->highlight($highlight);
        }

        $this->body['highlight'] = $value;

        return $this;
    }

    public function explain(bool $status): InnerHitsInterface
    {
        $this->body['explain'] = $status;

        return $this;
    }

    public function source(array | bool | string $source): InnerHitsInterface
    {
        $this->body['_source'] = $source;

        return $this;
    }

    public function script(callable | ScriptInterface $value): InnerHitsInterface
    {
        if (is_callable($value)) {
            $script = new Script();

            $value($script);

            return $this->script($script);
        }

        $this->body['script_fields'][] = $value;

        return $this;
    }

    public function docValueField(string $field, string | null $format = null): InnerHitsInterface
    {
        if (! $format) {
            $body = $field;
        } else {
            $body = [
                'field'  => $field,
                'format' => $format,
            ];
        }

        $this->body['docvalue_fields'][] = $body;

        return $this;
    }

    public function version(bool $status): InnerHitsInterface
    {
        $this->body['version'] = $status;

        return $this;
    }

    public function isEmpty(): bool
    {
        return empty($this->body);
    }

    public function build(): array
    {
        return Util::recursivetoArray($this->body);
    }
}
