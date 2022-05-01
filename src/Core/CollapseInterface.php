<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Core;

interface CollapseInterface extends ArrayableInterface, JsonableInterface
{
    public function field(string $field): CollapseInterface;

    public function innerHits(callable | InnerHitsInterface | null $value = null): CollapseInterface;

    public function maxConcurrentGroupSearches(int $maxConcurrentGroupSearches): CollapseInterface;
}
