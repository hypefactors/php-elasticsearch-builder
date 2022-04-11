<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Highlight;

use Hypefactors\ElasticBuilder\Query\QueryInterface;

interface HighlightInterface
{
    /**
     * A string that contains each boundary character.
     *
     * @param string      $chars
     * @param string|null $field
     *
     * @return \Hypefactors\ElasticBuilder\Highlight\HighlightInterface
     */
    public function boundaryChars(string $chars, ?string $field = null): HighlightInterface;

    /**
     * How far to scan for boundary characters.
     *
     * @param int         $maxScan
     * @param string|null $field
     *
     * @return \Hypefactors\ElasticBuilder\Highlight\HighlightInterface
     */
    public function boundaryMaxScan(int $maxScan, ?string $field = null): HighlightInterface;

    /**
     * Specifies how to break the highlighted fragments.
     *
     * @param string      $scanner
     * @param string|null $field
     *
     * @throws \InvalidArgumentException
     *
     * @return \Hypefactors\ElasticBuilder\Highlight\HighlightInterface
     */
    public function boundaryScanner(string $scanner, ?string $field = null): HighlightInterface;

    /**
     * Controls which locale is used to search for sentence and word boundaries.
     *
     * @param string      $locale
     * @param string|null $field
     *
     * @return \Hypefactors\ElasticBuilder\Highlight\HighlightInterface
     */
    public function boundaryScannerLocale(string $locale, ?string $field = null): HighlightInterface;

    /**
     * Indicates if the snippet should be HTML encoded.
     *
     * @param string $encoder
     *
     * @throws \InvalidArgumentException
     *
     * @return \Hypefactors\ElasticBuilder\Highlight\HighlightInterface
     */
    public function encoder(string $encoder): HighlightInterface;

    /**
     * Adds a field to be highlighted.
     *
     * @param string                                                        $field
     * @param \Hypefactors\ElasticBuilder\Highlight\HighlightInterface|null $highlight
     *
     * @return \Hypefactors\ElasticBuilder\Highlight\HighlightInterface
     */
    public function field(string $field, ?HighlightInterface $highlight = null): HighlightInterface;

    /**
     * Adds the given fields to be highlighted.
     *
     * @param array $fields
     *
     * @return \Hypefactors\ElasticBuilder\Highlight\HighlightInterface
     */
    public function fields(array $fields): HighlightInterface;

    /**
     * Highlight based on the source even if the field is stored separately.
     *
     * @param bool        $forceSource
     * @param string|null $field
     *
     * @return \Hypefactors\ElasticBuilder\Highlight\HighlightInterface
     */
    public function forceSource(bool $forceSource, ?string $field = null): HighlightInterface;

    /**
     * Specifies how text should be broken up in highlight snippets.
     *
     * @param string      $fragmenter
     * @param string|null $field
     *
     * @throws \InvalidArgumentException
     *
     * @return \Hypefactors\ElasticBuilder\Highlight\HighlightInterface
     */
    public function fragmenter(string $fragmenter, ?string $field = null): HighlightInterface;

    /**
     * Controls the margin from which you want to start highlighting.
     *
     * @param int         $offset
     * @param string|null $field
     *
     * @return \Hypefactors\ElasticBuilder\Highlight\HighlightInterface
     */
    public function fragmentOffset(int $offset, ?string $field = null): HighlightInterface;

    /**
     * The size of the highlighted fragment in characters.
     *
     * @param int         $size
     * @param string|null $field
     *
     * @return \Hypefactors\ElasticBuilder\Highlight\HighlightInterface
     */
    public function fragmentSize(int $size, ?string $field = null): HighlightInterface;

    /**
     * Highlight matches for a query other than the search query.
     *
     * @param \Hypefactors\ElasticBuilder\Query\QueryInterface $query
     * @param string|null                                      $field
     *
     * @return \Hypefactors\ElasticBuilder\Highlight\HighlightInterface
     */
    public function highlightQuery(QueryInterface $query, ?string $field = null): HighlightInterface;

    /**
     * Combine matches on multiple fields to highlight a single field.
     *
     * @param array  $fields
     * @param string $field
     *
     * @return \Hypefactors\ElasticBuilder\Highlight\HighlightInterface
     */
    public function matchedFields(array $fields, string $field): HighlightInterface;

    /**
     * The amount of text you want to return from the beginning of the field if there are no matching fragments to highlight.
     *
     * @param int    $size
     * @param string $field
     *
     * @return \Hypefactors\ElasticBuilder\Highlight\HighlightInterface
     */
    public function noMatchSize(int $size, string $field): HighlightInterface;

    /**
     * The maximum number of fragments to return.
     *
     * @param int         $maxFragments
     * @param string|null $field
     *
     * @return \Hypefactors\ElasticBuilder\Highlight\HighlightInterface
     */
    public function numberOfFragments(int $maxFragments, ?string $field = null): HighlightInterface;

    /**
     * Sorts highlighted fragments by score when set to score.
     *
     * @param string|null $field
     *
     * @return \Hypefactors\ElasticBuilder\Highlight\HighlightInterface
     */
    public function scoreOrder(?string $field = null): HighlightInterface;

    /**
     * Controls the number of matching phrases in a document that are considered.
     *
     * @param int $limit
     *
     * @return \Hypefactors\ElasticBuilder\Highlight\HighlightInterface
     */
    public function phraseLimit(int $limit): HighlightInterface;

    /**
     * Use in conjunction with post_tags to define the HTML tags to use for the highlighted text.
     *
     * @param array|string $tags
     * @param string|null  $field
     *
     * @return \Hypefactors\ElasticBuilder\Highlight\HighlightInterface
     */
    public function preTags($tags, ?string $field = null): HighlightInterface;

    /**
     * Use in conjunction with pre_tags to define the HTML tags to use for the highlighted text.
     *
     * @param array|string $tags
     * @param string|null  $field
     *
     * @return \Hypefactors\ElasticBuilder\Highlight\HighlightInterface
     */
    public function postTags($tags, ?string $field = null): HighlightInterface;

    /**
     * By default, only fields that contains a query match are highlighted.
     *
     * @param bool        $requireFieldMatch
     * @param string|null $field
     *
     * @return \Hypefactors\ElasticBuilder\Highlight\HighlightInterface
     */
    public function requireFieldMatch(bool $requireFieldMatch, ?string $field = null): HighlightInterface;

    /**
     * Set to styled to use the built-in tag schema.
     *
     * @return \Hypefactors\ElasticBuilder\Highlight\HighlightInterface
     */
    public function tagsSchema(): HighlightInterface;

    /**
     * The highlighter to use.
     *
     * @param string      $type
     * @param string|null $field
     *
     * @throws \InvalidArgumentException
     *
     * @return \Hypefactors\ElasticBuilder\Highlight\HighlightInterface
     */
    public function type(string $type, ?string $field = null): HighlightInterface;

    /**
     * Returns the DSL Query as an array.
     *
     * @return array
     */
    public function toArray(): array;

    /**
     * Returns the query in JSON format.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson(int $options = 0): string;
}
