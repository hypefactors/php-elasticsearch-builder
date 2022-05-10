<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\TermLevel;

use Hypefactors\ElasticBuilder\Core\ArrayableInterface;
use Hypefactors\ElasticBuilder\Query\QueryInterface;

interface IdsQueryInterface extends ArrayableInterface, QueryInterface
{
    /**
     * Sets the documents ids to be returned.
     */
    public function values(array $ids): IdsQueryInterface;
}
