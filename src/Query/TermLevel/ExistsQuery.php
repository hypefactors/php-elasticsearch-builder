<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\TermLevel;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Query;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-exists-query.html
 */
class ExistsQuery extends Query implements ExistsQueryInterface
{
    public function field(string $field): ExistsQueryInterface
    {
        $this->body['field'] = $field;

        return $this;
    }

    public function build(): array
    {
        if (! isset($this->body['field'])) {
            throw new InvalidArgumentException('The "field" is required!');
        }

        return [
            'exists' => Util::recursivetoArray($this->body),
        ];
    }
}
