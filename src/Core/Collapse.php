<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Core;

use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/collapse-search-results.html
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

        $this->body['inner_hits'] = $value->build();

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

    public function build(): array
    {
        if (! isset($this->body['field'])) {
            throw new InvalidArgumentException('The "field" is required!');
        }

        return Util::recursivetoArray($this->body);
    }
}
