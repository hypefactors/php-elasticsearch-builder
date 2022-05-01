<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Core;

use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/collapse-search-results.html
 */
class Collapse implements CollapseInterface
{
    private array $body = [];

    public function field(string $field): CollapseInterface
    {
        $this->body['field'] = $field;

        return $this;
    }

    public function innerHits(callable | InnerHitsInterface | null $value = null): CollapseInterface
    {
        if (is_callable($value)) {
            $innerHits = new InnerHits();

            $value($innerHits);

            return $this->innerHits($innerHits);
        }

        $this->body['inner_hits'] = $value->toArray();

        return $this;
    }

    public function maxConcurrentGroupSearches(int $maxConcurrentGroupSearches): CollapseInterface
    {
        $this->body['max_concurrent_group_searches'] = $maxConcurrentGroupSearches;

        return $this;
    }

    public function isEmpty(): bool
    {
        return empty($this->body);
    }

    public function toArray(): array
    {
        if (! isset($this->body['field'])) {
            throw new InvalidArgumentException('The "field" is required!');
        }

        return Util::recursivetoArray($this->body);
    }

    public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
