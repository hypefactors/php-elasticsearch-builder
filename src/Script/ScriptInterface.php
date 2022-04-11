<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Script;

interface ScriptInterface
{
    /**
     * Specifies the id of the stored script.
     *
     * @param string $id
     *
     * @return \Hypefactors\ElasticBuilder\Script\ScriptInterface
     */
    public function id(string $id): ScriptInterface;

    /**
     * Specifies the source of the script.
     *
     * @param string $source
     *
     * @return \Hypefactors\ElasticBuilder\Script\ScriptInterface
     */
    public function source(string $source): ScriptInterface;

    /**
     * Specifies the language the script is written in.
     *
     * @param string $language
     *
     * @return \Hypefactors\ElasticBuilder\Script\ScriptInterface
     */
    public function language(string $language): ScriptInterface;

    /**
     * Specifies any named parameters that are passed into the script as variables.
     *
     * @param array $parameters
     *
     * @return \Hypefactors\ElasticBuilder\Script\ScriptInterface
     */
    public function parameters(array $parameters): ScriptInterface;

    /**
     * Returns the DSL Query as an array.
     *
     * @throws \InvalidArgumentException
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
