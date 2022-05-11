<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Core;

use Hypefactors\ElasticBuilder\Query\QueryInterface;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.17/highlighting.html
 */
class Highlight implements HighlightInterface
{
    /**
     * The parameters that will be used when building the Highlight response.
     */
    private array $parameters = [];

    /**
     * The fields that will be highlighted.
     */
    private array $fields = [];

    /**
     * List of valid boundary scanners.
     */
    public const VALID_BOUNDARY_SCANNERS = [
        'chars',
        'sentence',
        'word',
    ];

    /**
     * List of valid encoders.
     */
    public const VALID_ENCODERS = [
        'default',
        'html',
    ];

    /**
     * List of valid fragmenters.
     */
    public const VALID_FRAGMENTERS = [
        'simple',
        'span',
    ];

    /**
     * List of valid types.
     */
    public const VALID_TYPES = [
        'unified',
        'plain',
        'fvh',
    ];

    public function boundaryChars(string $chars, string | null $field = null): HighlightInterface
    {
        $this->setParameter('boundary_chars', $chars, $field);

        return $this;
    }

    public function boundaryMaxScan(int $maxScan, string | null $field = null): HighlightInterface
    {
        $this->setParameter('boundary_max_scan', $maxScan, $field);

        return $this;
    }

    public function boundaryScanner(string $scanner, string | null $field = null): HighlightInterface
    {
        $scannerLower = strtolower($scanner);

        if (! in_array($scannerLower, self::VALID_BOUNDARY_SCANNERS, true)) {
            throw new InvalidArgumentException("The [{$scanner}] boundary scanner is invalid!");
        }

        $this->setParameter('boundary_scanner', $scanner, $field);

        return $this;
    }

    public function boundaryScannerLocale(string $locale, string | null $field = null): HighlightInterface
    {
        $this->setParameter('boundary_scanner_locale', $locale, $field);

        return $this;
    }

    public function encoder(string $encoder): HighlightInterface
    {
        $encoderLower = strtolower($encoder);

        if (! in_array($encoderLower, self::VALID_ENCODERS, true)) {
            throw new InvalidArgumentException("The [{$encoder}] encoder is invalid!");
        }

        $this->setParameter('encoder', $encoderLower);

        return $this;
    }

    public function field(string $field, HighlightInterface | null $highlight = null): HighlightInterface
    {
        if (! isset($this->fields[$field])) {
            $this->fields[$field] = $highlight ?: [];
        }

        return $this;
    }

    public function fields(array $fields): HighlightInterface
    {
        foreach ($fields as $key => $value) {
            $field = is_int($key) ? $value : $key;

            $highlight = ! is_int($key) && is_object($value) ? $value : null;

            $this->field($field, $highlight);
        }

        return $this;
    }

    public function forceSource(bool $forceSource, string | null $field = null): HighlightInterface
    {
        $this->setParameter('force_source', $forceSource, $field);

        return $this;
    }

    public function fragmenter(string $fragmenter, string | null $field = null): HighlightInterface
    {
        $fragmenterLower = strtolower($fragmenter);

        if (! in_array($fragmenterLower, self::VALID_FRAGMENTERS, true)) {
            throw new InvalidArgumentException("The [{$fragmenter}] fragmenter is invalid!");
        }

        $this->setParameter('fragmenter', $fragmenterLower, $field);

        return $this;
    }

    public function fragmentOffset(int $offset, string $field): HighlightInterface
    {
        $this->type('fvh', $field);

        $this->setParameter('fragment_offset', $offset, $field);

        return $this;
    }

    public function fragmentSize(int $size, string | null $field = null): HighlightInterface
    {
        $this->setParameter('fragment_size', $size, $field);

        return $this;
    }

    public function highlightQuery(QueryInterface $query, string | null $field = null): HighlightInterface
    {
        $this->setParameter('highlight_query', $query, $field);

        return $this;
    }

    public function matchedFields(array $fields, string $field): HighlightInterface
    {
        $this->type('fvh', $field);

        $this->setParameter('matched_fields', $fields, $field);

        return $this;
    }

    public function noMatchSize(int $size, string $field): HighlightInterface
    {
        $this->setParameter('no_match_size', $size, $field);

        return $this;
    }

    public function numberOfFragments(int $maxFragments, string | null $field = null): HighlightInterface
    {
        $this->setParameter('number_of_fragments', $maxFragments, $field);

        return $this;
    }

    public function scoreOrder(string | null $field = null): HighlightInterface
    {
        $this->setParameter('order', 'score', $field);

        return $this;
    }

    public function phraseLimit(int $limit): HighlightInterface
    {
        $this->setParameter('phrase_limit', $limit);

        return $this;
    }

    public function preTags(array | string $tags, string | null $field = null): HighlightInterface
    {
        $tags = Util::arrayWrap($tags);

        $this->setParameter('pre_tags', $tags, $field);

        return $this;
    }

    public function postTags(array | string $tags, string | null $field = null): HighlightInterface
    {
        $tags = Util::arrayWrap($tags);

        $this->setParameter('post_tags', $tags, $field);

        return $this;
    }

    public function requireFieldMatch(bool $requireFieldMatch, string | null $field = null): HighlightInterface
    {
        $this->setParameter('require_field_match', $requireFieldMatch, $field);

        return $this;
    }

    public function tagsSchema(): HighlightInterface
    {
        $this->setParameter('tags_schema', 'styled');

        return $this;
    }

    public function type(string $type, string | null $field = null): HighlightInterface
    {
        $typeLower = strtolower($type);

        if (! in_array($typeLower, self::VALID_TYPES, true)) {
            throw new InvalidArgumentException("The [{$type}] type is invalid!");
        }

        $this->setParameter('type', $typeLower, $field);

        return $this;
    }

    public function isEmpty(): bool
    {
        return empty($this->build());
    }

    public function build(): array
    {
        $parameters = Util::recursivetoArray($this->parameters);

        $fields = Util::recursivetoArray($this->fields);

        return array_merge($parameters, array_filter([
            'fields' => $fields,
        ]));
    }

    /**
     * Sets the given parameter and value on either the main response or if provided, on the field directly.
     */
    private function setParameter(string $parameter, mixed $value, string | null $field = null): HighlightInterface
    {
        if ($field) {
            $this->fields[$field][$parameter] = $value;
        } else {
            $this->parameters[$parameter] = $value;
        }

        return $this;
    }
}
