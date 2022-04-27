<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Core;

interface ArrayableInterface
{
    /**
     * Converts the object to an array.
     */
    public function toArray(): array;
}
