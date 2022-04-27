<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Core;

interface ScriptInterface extends ArrayableInterface, JsonableInterface
{
    /**
     * Specifies the id of the stored script.
     */
    public function id(string $id): ScriptInterface;

    /**
     * Specifies the source of the script.
     */
    public function source(string $source): ScriptInterface;

    /**
     * Specifies the language the script is written in.
     */
    public function language(string $language): ScriptInterface;

    /**
     * Specifies any named parameters that are passed into the script as variables.
     */
    public function parameters(array $parameters): ScriptInterface;
}
