<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\Compound;

use Hypefactors\ElasticBuilder\Core\ArrayableInterface;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\FilterQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\MustNotQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\MustQueryInterface;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery\ShouldQueryInterface;
use Hypefactors\ElasticBuilder\Query\QueryInterface;

interface BoolQueryInterface extends ArrayableInterface, QueryInterface
{
    public function filter(callable | FilterQueryInterface $value): BoolQueryInterface;

    public function must(callable | MustQueryInterface $value): BoolQueryInterface;

    public function mustNot(callable | MustNotQueryInterface $value): BoolQueryInterface;

    public function should(callable | ShouldQueryInterface $value): BoolQueryInterface;

    public function minimumShouldMatch($minimumShouldMatch): BoolQueryInterface;
}
