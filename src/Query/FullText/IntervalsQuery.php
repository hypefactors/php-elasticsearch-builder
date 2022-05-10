<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Query\FullText;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\AllOfRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\AnyOfRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\FuzzyRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\MatchRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\PrefixRule;
use Hypefactors\ElasticBuilder\Query\FullText\IntervalsQueryRule\WildcardRule;
use Hypefactors\ElasticBuilder\Query\Query;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/query-dsl-intervals-query.html
 */
class IntervalsQuery extends Query implements IntervalsQueryInterface
{
    private string | null $field = null;

    public function field(string $field): IntervalsQueryInterface
    {
        $this->field = $field;

        return $this;
    }

    public function match(callable | MatchRule $value): IntervalsQueryInterface
    {
        if (is_callable($value)) {
            $matchRule = new MatchRule();

            $value($matchRule);

            return $this->match($matchRule);
        }

        $this->body[] = $value;

        return $this;
    }

    public function prefix(callable | PrefixRule $value): IntervalsQueryInterface
    {
        if (is_callable($value)) {
            $prefixRule = new PrefixRule();

            $value($prefixRule);

            return $this->prefix($prefixRule);
        }

        $this->body[] = $value;

        return $this;
    }

    public function wildcard(callable | WildcardRule $value): IntervalsQueryInterface
    {
        if (is_callable($value)) {
            $wildcardRule = new WildcardRule();

            $value($wildcardRule);

            return $this->wildcard($wildcardRule);
        }

        $this->body[] = $value;

        return $this;
    }

    public function fuzzy(callable | FuzzyRule $value): IntervalsQueryInterface
    {
        if (is_callable($value)) {
            $fuzzyRule = new FuzzyRule();

            $value($fuzzyRule);

            return $this->fuzzy($fuzzyRule);
        }

        $this->body[] = $value;

        return $this;
    }

    public function allOf(callable | AllOfRule $value): IntervalsQueryInterface
    {
        if (is_callable($value)) {
            $allOfRule = new AllOfRule();

            $value($allOfRule);

            return $this->allOf($allOfRule);
        }

        $this->body[] = $value;

        return $this;
    }

    public function anyOf(callable | AnyOfRule $value): IntervalsQueryInterface
    {
        if (is_callable($value)) {
            $anyOfRule = new AnyOfRule();

            $value($anyOfRule);

            return $this->anyOf($anyOfRule);
        }

        $this->body[] = $value;

        return $this;
    }

    // TODO: Temporary solution
    private bool $requiresField = true;

    public function setRequiresField(bool $status): self
    {
        $this->requiresField = $status;

        return $this;
    }
    // END TODO

    public function build(): array
    {
        if (! $this->field && $this->requiresField) {
            throw new InvalidArgumentException('The "field" is required!');
        }

        if (empty($this->body)) {
            return [];
        }

        if ($this->field) {
            if (count($this->body) === 1) {
                $body = $this->body[0]->build();
            } else {
                $body = $this->body;
            }

            return [
                'intervals' => [
                    $this->field => Util::recursivetoArray($body),
                ],
            ];
        }

        return [
            'intervals' => Util::recursivetoArray($this->body),
        ];
    }
}
