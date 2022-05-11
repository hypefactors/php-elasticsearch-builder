<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\TermLevel;

use Hypefactors\ElasticBuilder\Query\Query;
use RuntimeException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-terms-set-query.html
 */
class TermsSetQuery extends Query implements TermsSetQueryInterface
{
    /**
     * The field to search on.
     */
    private string | null $field = null;

    public function field($field): TermsSetQueryInterface
    {
        $this->field = $field;

        return $this;
    }

    public function term(string $term): TermsSetQueryInterface
    {
        $this->body['terms'][] = $term;

        return $this;
    }

    public function terms(array $terms): TermsSetQueryInterface
    {
        $this->body['terms'] = $terms;

        return $this;
    }

    public function minimumShouldMatchField(string $fieldName): TermsSetQueryInterface
    {
        $this->body['minimum_should_match_field'] = $fieldName;

        return $this;
    }

    public function minimumShouldMatchScript($script): TermsSetQueryInterface
    {
        $this->body['minimum_should_match_script'] = $script;

        return $this;
    }

    public function build(): array
    {
        if (! empty($this->body['terms'])) {
            if (! isset($this->body['minimum_should_match_field']) && ! isset($this->body['minimum_should_match_script'])) {
                throw new RuntimeException("When defining 'terms' the 'minimum_should_match_field' or 'minimum_should_match_script' should be defined.");
            }
        }

        return [
            'terms_set' => [
                $this->field => $this->body,
            ],
        ];
    }
}
