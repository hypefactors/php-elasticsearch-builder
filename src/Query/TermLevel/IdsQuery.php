<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\TermLevel;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Query;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-ids-query.html
 */
class IdsQuery extends Query
{
    /**
     * Sets the type of the documents to be returned.
     *
     * @param string $ids
     *
     * @return $this
     */
    public function type(string $type): self
    {
        $this->body['type'] = $type;

        return $this;
    }

    /**
     * Sets the documents ids to be returned.
     *
     * @param string $ids
     *
     * @return $this
     */
    public function values(array $ids): self
    {
        $this->body['values'] = $ids;

        return $this;
    }

    /**
     * Returns the DSL Query as an array.
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function toArray(): array
    {
        if (! isset($this->body['values'])) {
            throw new InvalidArgumentException('The "values" are required!');
        }

        if (empty($this->body['values'])) {
            throw new InvalidArgumentException('The "values" cannot be empty!');
        }

        return [
            'ids' => Util::recursivetoArray($this->body),
        ];
    }
}
