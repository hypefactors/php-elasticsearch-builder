<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Core;

use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/modules-scripting.html
 */
final class Script implements ScriptInterface
{
    /**
     * The parameters that will be used when building the Script response.
     */
    private array $parameters = [];

    public function id(string $id): ScriptInterface
    {
        $this->parameters['id'] = $id;

        return $this;
    }

    public function source(string $source): ScriptInterface
    {
        $this->parameters['source'] = $source;

        return $this;
    }

    public function language(string $language): ScriptInterface
    {
        $this->parameters['lang'] = $language;

        return $this;
    }

    public function parameters(array $parameters): ScriptInterface
    {
        $this->parameters['params'] = $parameters;

        return $this;
    }

    public function toArray(): array
    {
        if (! isset($this->parameters['source']) && ! isset($this->parameters['id'])) {
            throw new InvalidArgumentException('The "source" or "id" is required!');
        }

        if (isset($this->parameters['source'], $this->parameters['id'])) {
            throw new InvalidArgumentException('Passing both "source" and "id" at the same time is not allowed.');
        }

        return Util::arrayWrap($this->parameters);
    }

    public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
