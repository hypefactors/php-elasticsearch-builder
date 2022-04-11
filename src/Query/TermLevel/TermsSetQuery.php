<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\Query;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-terms-set-query.html
 */
class TermsSetQuery extends Query
{
    /**
     * The field to search on.
     *
     * @var string
     */
    protected $field;

    /**
     * Sets the field to search on.
     *
     * @param string $field
     *
     * @return $this
     */
    public function field($field): self
    {
        $this->field = $field;

        return $this;
    }

    public function term(string $term): self
    {
        $this->body['terms'][] = $term;

        return $this;
    }

    public function terms($terms): self
    {
        $this->body['terms'] = $terms;

        return $this;
    }

    public function minimumShouldMatchField(string $fieldName): self
    {
        $this->body['minimum_should_match_field'] = $fieldName;

        return $this;
    }

    public function minimumShouldMatchScript($script): self
    {
        $this->body['minimum_should_match_script'] = $script;

        return $this;
    }

    /**
     * Returns the DSL Query as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'terms_set' => [
                $this->field => $this->body,
            ],
        ];
    }
}
