<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Highlight;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\QueryInterface;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/highlighting.html
 */
final class Highlight implements HighlightInterface
{
    /**
     * The parameters that will be used when building the Highlight response.
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * The fields that will be highlighted.
     *
     * @var array
     */
    protected $fields = [];

    /**
     * List of valid boundary scanners.
     *
     * @var array
     */
    public const VALID_BOUNDARY_SCANNERS = ['chars', 'sentence', 'word'];

    /**
     * List of valid encoders.
     *
     * @var array
     */
    public const VALID_ENCODERS = ['default', 'html'];

    /**
     * List of valid fragmenters.
     *
     * @var array
     */
    public const VALID_FRAGMENTERS = ['simple', 'span'];

    /**
     * List of valid types.
     *
     * @var array
     */
    public const VALID_TYPES = ['unified', 'plain', 'fvh'];

    /**
     * {@inheritdoc}
     */
    public function boundaryChars(string $chars, ?string $field = null): HighlightInterface
    {
        $this->setParameter('boundary_chars', $chars, $field);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function boundaryMaxScan(int $maxScan, ?string $field = null): HighlightInterface
    {
        $this->setParameter('boundary_max_scan', $maxScan, $field);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function boundaryScanner(string $scanner, ?string $field = null): HighlightInterface
    {
        $scannerLower = strtolower($scanner);

        if (! in_array($scannerLower, self::VALID_BOUNDARY_SCANNERS, true)) {
            throw new InvalidArgumentException("The [{$scanner}] boundary scanner is invalid!");
        }

        $this->setParameter('boundary_scanner', $scanner, $field);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function boundaryScannerLocale(string $locale, ?string $field = null): HighlightInterface
    {
        $this->setParameter('boundary_scanner_locale', $locale, $field);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function encoder(string $encoder): HighlightInterface
    {
        $encoderLower = strtolower($encoder);

        if (! in_array($encoderLower, self::VALID_ENCODERS, true)) {
            throw new InvalidArgumentException("The [{$encoder}] encoder is invalid!");
        }

        $this->setParameter('encoder', $encoderLower);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function field(string $field, ?HighlightInterface $highlight = null): HighlightInterface
    {
        if (! isset($this->fields[$field])) {
            $this->fields[$field] = $highlight ?: [];
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function fields(array $fields): HighlightInterface
    {
        foreach ($fields as $key => $value) {
            $field = is_int($key) ? $value : $key;

            $highlight = ! is_int($key) && is_object($value) ? $value : null;

            $this->field($field, $highlight);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function forceSource(bool $forceSource, ?string $field = null): HighlightInterface
    {
        $this->setParameter('force_source', $forceSource, $field);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function fragmenter(string $fragmenter, ?string $field = null): HighlightInterface
    {
        $fragmenterLower = strtolower($fragmenter);

        if (! in_array($fragmenterLower, self::VALID_FRAGMENTERS, true)) {
            throw new InvalidArgumentException("The [{$fragmenter}] fragmenter is invalid!");
        }

        $this->setParameter('fragmenter', $fragmenterLower, $field);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function fragmentOffset(int $offset, ?string $field = null): HighlightInterface
    {
        $this->type('fvh', $field);

        $this->setParameter('fragment_offset', $offset, $field);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function fragmentSize(int $size, ?string $field = null): HighlightInterface
    {
        $this->setParameter('fragment_size', $size, $field);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function highlightQuery(QueryInterface $query, ?string $field = null): HighlightInterface
    {
        $this->setParameter('highlight_query', $query, $field);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function matchedFields(array $fields, string $field): HighlightInterface
    {
        $this->type('fvh', $field);

        $this->setParameter('matched_fields', $fields, $field);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function noMatchSize(int $size, string $field): HighlightInterface
    {
        $this->setParameter('no_match_size', $size, $field);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function numberOfFragments(int $maxFragments, ?string $field = null): HighlightInterface
    {
        $this->setParameter('number_of_fragments', $maxFragments, $field);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function scoreOrder(?string $field = null): HighlightInterface
    {
        $this->setParameter('order', 'score', $field);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function phraseLimit(int $limit): HighlightInterface
    {
        $this->setParameter('phrase_limit', $limit);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function preTags($tags, ?string $field = null): HighlightInterface
    {
        $tags = Util::arrayWrap($tags);

        $this->setParameter('pre_tags', $tags, $field);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function postTags($tags, ?string $field = null): HighlightInterface
    {
        $tags = Util::arrayWrap($tags);

        $this->setParameter('post_tags', $tags, $field);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function requireFieldMatch(bool $requireFieldMatch, ?string $field = null): HighlightInterface
    {
        $this->setParameter('require_field_match', $requireFieldMatch, $field);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function tagsSchema(): HighlightInterface
    {
        $this->setParameter('tags_schema', 'styled');

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function type(string $type, ?string $field = null): HighlightInterface
    {
        $typeLower = strtolower($type);

        if (! in_array($typeLower, self::VALID_TYPES, true)) {
            throw new InvalidArgumentException("The [{$type}] type is invalid!");
        }

        $this->setParameter('type', $typeLower, $field);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $parameters = Util::recursivetoArray($this->parameters);

        $fields = Util::recursivetoArray($this->fields);

        return array_merge($parameters, array_filter([
            'fields' => $fields,
        ]));
    }

    /**
     * {@inheritdoc}
     */
    public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Sets the given parameter and value on either the main response or if provided, on the field directly.
     *
     * @param string      $parameter
     * @param mixed       $value
     * @param string|null $field
     *
     * @return self
     */
    protected function setParameter(string $parameter, $value, ?string $field = null): HighlightInterface
    {
        if ($field) {
            $this->fields[$field][$parameter] = $value;
        } else {
            $this->parameters[$parameter] = $value;
        }

        return $this;
    }
}
