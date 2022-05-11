<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Compound\BoolQuery;

use Hypefactors\ElasticBuilder\Core\ArrayableInterface;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQueryInterface;
use Hypefactors\ElasticBuilder\Query\Concerns\FullTextQueriesInterface;
use Hypefactors\ElasticBuilder\Query\Concerns\TermLevelQueriesInterface;

interface MustNotQueryInterface extends
    ArrayableInterface,
    FullTextQueriesInterface,
    TermLevelQueriesInterface
{
    public function bool(callable | BoolQueryInterface $value): MustNotQueryInterface;
}
