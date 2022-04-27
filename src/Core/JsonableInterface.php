<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Core;

interface JsonableInterface
{
    /**
     * Converts the object to its JSON representation.
     */
    public function toJson(int $options = 0): string;
}
