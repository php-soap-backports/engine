<?php

declare(strict_types=1);

namespace Soap\Engine;

use Soap\Engine\Metadata\Metadata;

final class LazyEngine implements Engine
{
    /**
     * @var callable(): Engine
     */
    private $factory;

    /**
     * @var Engine|null
     */
    private $engine = null;

    /**
     * @param callable(): Engine $factory
     */
    public function __construct(callable $factory)
    {
        $this->factory = $factory;
    }

    public function request(string $method, array $arguments)
    {
        return $this->engine()->request($method, $arguments);
    }

    private function engine(): Engine
    {
        if (!$this->engine) {
            $this->engine = ($this->factory)();
        }

        return $this->engine;
    }

    public function getMetadata(): Metadata
    {
        return $this->engine()->getMetadata();
    }
}
