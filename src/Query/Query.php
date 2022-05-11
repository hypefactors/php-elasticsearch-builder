<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query;

abstract class Query implements QueryInterface
{
    protected array $body = [];

    public function boost(float $factor): self
    {
        $this->body['boost'] = $factor;

        return $this;
    }

    public function name(string $name): self
    {
        $this->body['_name'] = $name;

        return $this;
    }

    public function isEmpty(): bool
    {
        return empty($this->build());
    }
}
