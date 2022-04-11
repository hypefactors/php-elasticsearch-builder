<?php

declare(strict_types = 1);

namespace Hypefactors\ElasticBuilder\Script;

use Hypefactors\ElasticBuilder\Core\Util;
use InvalidArgumentException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/modules-scripting.html
 */
final class Script implements ScriptInterface
{
    /**
     * The parameters that will be used when building the Script response.
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * {@inheritdoc}
     */
    public function id(string $id): ScriptInterface
    {
        $this->parameters['id'] = $id;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function source(string $source): ScriptInterface
    {
        $this->parameters['source'] = $source;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function language(string $language): ScriptInterface
    {
        $this->parameters['lang'] = $language;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function parameters(array $parameters): ScriptInterface
    {
        $this->parameters['params'] = $parameters;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
