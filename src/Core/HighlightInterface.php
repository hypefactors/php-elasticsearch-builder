<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Core;

use Hypefactors\ElasticBuilder\Query\QueryInterface;

interface HighlightInterface extends ArrayableInterface, JsonableInterface
{
    /**
     * A string that contains each boundary character.
     */
    public function boundaryChars(string $chars, string | null $field = null): HighlightInterface;

    /**
     * How far to scan for boundary characters.
     */
    public function boundaryMaxScan(int $maxScan, string | null $field = null): HighlightInterface;

    /**
     * Specifies how to break the highlighted fragments.
     */
    public function boundaryScanner(string $scanner, string | null $field = null): HighlightInterface;

    /**
     * Controls which locale is used to search for sentence and word boundaries.
     */
    public function boundaryScannerLocale(string $locale, string | null $field = null): HighlightInterface;

    /**
     * Indicates if the snippet should be HTML encoded.
     */
    public function encoder(string $encoder): HighlightInterface;

    /**
     * Adds a field to be highlighted.
     */
    public function field(string $field, HighlightInterface | null $highlight = null): HighlightInterface;

    /**
     * Adds the given fields to be highlighted.
     */
    public function fields(array $fields): HighlightInterface;

    /**
     * Highlight based on the source even if the field is stored separately.
     */
    public function forceSource(bool $forceSource, string | null $field = null): HighlightInterface;

    /**
     * Specifies how text should be broken up in highlight snippets.
     */
    public function fragmenter(string $fragmenter, string | null $field = null): HighlightInterface;

    /**
     * Controls the margin from which you want to start highlighting.
     */
    public function fragmentOffset(int $offset, string | null $field = null): HighlightInterface;

    /**
     * The size of the highlighted fragment in characters.
     */
    public function fragmentSize(int $size, string | null $field = null): HighlightInterface;

    /**
     * Highlight matches for a query other than the search query.
     */
    public function highlightQuery(QueryInterface $query, string | null $field = null): HighlightInterface;

    /**
     * Combine matches on multiple fields to highlight a single field.
     */
    public function matchedFields(array $fields, string $field): HighlightInterface;

    /**
     * The amount of text you want to return from the beginning of the field if there are no matching fragments to highlight.
     */
    public function noMatchSize(int $size, string $field): HighlightInterface;

    /**
     * The maximum number of fragments to return.
     */
    public function numberOfFragments(int $maxFragments, string | null $field = null): HighlightInterface;

    /**
     * Sorts highlighted fragments by score when set to score.
     */
    public function scoreOrder(string | null $field = null): HighlightInterface;

    /**
     * Controls the number of matching phrases in a document that are considered.
     */
    public function phraseLimit(int $limit): HighlightInterface;

    /**
     * Use in conjunction with post_tags to define the HTML tags to use for the highlighted text.
     */
    public function preTags(array | string $tags, string | null $field = null): HighlightInterface;

    /**
     * Use in conjunction with pre_tags to define the HTML tags to use for the highlighted text.
     */
    public function postTags(array | string $tags, string | null $field = null): HighlightInterface;

    /**
     * By default, only fields that contains a query match are highlighted.
     */
    public function requireFieldMatch(bool $requireFieldMatch, string | null $field = null): HighlightInterface;

    /**
     * Set to styled to use the built-in tag schema.
     */
    public function tagsSchema(): HighlightInterface;

    /**
     * The highlighter to use.
     */
    public function type(string $type, string | null $field = null): HighlightInterface;
}
