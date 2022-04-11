<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query;

abstract class Query implements QueryInterface
{
    /**
     * The DSL Query body.
     *
     * @var array
     */
    protected $body = [];

    /**
     * {@inheritdoc}
     */
    public function boost(float $factor): QueryInterface
    {
        $this->body['boost'] = $factor;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function name(string $name): QueryInterface
    {
        $this->body['_name'] = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
