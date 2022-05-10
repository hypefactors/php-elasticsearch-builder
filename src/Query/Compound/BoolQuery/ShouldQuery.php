<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Compound\BoolQuery;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQueryInterface;
use Hypefactors\ElasticBuilder\Query\Concerns\FullTextQueries;
use Hypefactors\ElasticBuilder\Query\Concerns\TermLevelQueries;
use Hypefactors\ElasticBuilder\Query\Query;

class ShouldQuery extends Query implements ShouldQueryInterface
{
    use FullTextQueries;
    use TermLevelQueries;

    public function bool(callable | BoolQueryInterface $value): ShouldQueryInterface
    {
        if (is_callable($value)) {
            $boolQuery = new BoolQuery();

            $value($boolQuery);

            return $this->bool($boolQuery);
        }

        if (! $value->isEmpty()) {
            $this->body[] = $value;
        }

        return $this;
    }

    public function build(): array
    {
        if (empty($this->body)) {
            return [];
        }

        if (count($this->body) === 1) {
            return $this->body[0]->build();
        }

        return Util::recursivetoArray($this->body);
    }
}
