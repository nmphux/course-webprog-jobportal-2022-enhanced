<?php

namespace Core;

class ServiceContainer
{
    /** @var array<string, callable> Factory closures */
    private array $bindings = [];

    /** @var array<string, mixed> Cached singleton instances */
    private array $instances = [];

    /** @var array<string, bool> Tracks which bindings are singletons */
    private array $singletons = [];

    /**
     * Register a factory binding.
     * Each call to get() will invoke the factory and return a new instance.
     */
    public function bind(string $name, callable $factory): void
    {
        $this->bindings[$name] = $factory;
        unset($this->singletons[$name], $this->instances[$name]);
    }

    /**
     * Register a singleton binding.
     * The factory is called once on first get(); subsequent calls return the cached instance.
     */
    public function singleton(string $name, callable $factory): void
    {
        $this->bindings[$name] = $factory;
        $this->singletons[$name] = true;
        unset($this->instances[$name]);
    }

    /**
     * Resolve a binding by name.
     *
     * @throws \RuntimeException If the binding does not exist.
     */
    public function get(string $name): mixed
    {
        // Return cached singleton if already resolved
        if (isset($this->instances[$name])) {
            return $this->instances[$name];
        }

        if (!isset($this->bindings[$name])) {
            throw new \RuntimeException("No binding registered for '{$name}'.");
        }

        $instance = ($this->bindings[$name])($this);

        // Cache if registered as singleton
        if (isset($this->singletons[$name])) {
            $this->instances[$name] = $instance;
        }

        return $instance;
    }

    /**
     * Check whether a binding exists.
     */
    public function has(string $name): bool
    {
        return isset($this->bindings[$name]);
    }
}
