<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\TermLevel;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Query;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-ids-query.html
 */
class IdsQuery extends Query implements IdsQueryInterface
{
    public function values(array $ids): IdsQueryInterface
    {
        $this->body['values'] = $ids;

        return $this;
    }

    public function build(): array
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
