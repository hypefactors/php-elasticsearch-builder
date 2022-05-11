<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\TermLevel;

use Hypefactors\ElasticBuilder\Core\ArrayableInterface;
use Hypefactors\ElasticBuilder\Query\QueryInterface;

interface TermsSetQueryInterface extends ArrayableInterface, QueryInterface
{
    /**
     * Sets the field to search on.
     */
    public function field(string $field): TermsSetQueryInterface;

    public function term(string $term): TermsSetQueryInterface;

    public function terms(array $terms): TermsSetQueryInterface;

    public function minimumShouldMatchField(string $fieldName): TermsSetQueryInterface;

    public function minimumShouldMatchScript($script): TermsSetQueryInterface;
}
