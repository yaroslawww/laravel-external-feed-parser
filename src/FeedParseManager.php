<?php

namespace ExternalFeedParser;

use ExternalFeedParser\Contracts\Converter;
use ExternalFeedParser\Contracts\Provider;
use ExternalFeedParser\Contracts\PullProcessor;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Arr;
use InvalidArgumentException;

class FeedParseManager
{

    /**
     * Resolved providers.
     */
    protected array $providers = [];

    public function __construct(
        protected Application $app
    ) {
    }

    /**
     * Get a provider instance by name.
     */
    public function provider(string $name): Provider
    {
        return $this->providers[$name] = $this->get($name);
    }

    /**
     * Attempt to get the provider from the local cache.
     */
    protected function get(string $name): Provider
    {
        return $this->providers[$name] ?? $this->resolve($name);
    }

    /**
     * Resolve the given provider.
     *
     * @throws \InvalidArgumentException
     */
    protected function resolve(string $name): Provider
    {
        $config = $this->getConfig($name);

        if (is_null($config)) {
            throw new InvalidArgumentException("Feed parser provider [{$name}] is not defined.");
        }

        $class = $this->app['config']['external-feed-parser.provider_class'];

        if (!is_a($class, Provider::class, true)) {
            throw new InvalidArgumentException("Feed provider has wrong class [{$class}].");
        }

        $pullClass = Arr::get($config, 'pull.class');
        $pullArgs  = Arr::get($config, 'pull.options', []);

        if (!is_a($pullClass, PullProcessor::class, true)) {
            throw new InvalidArgumentException("Pull processor has wrong class [{$pullClass}].");
        }

        $convertClass = Arr::get($config, 'convert.class');
        $convertArgs  = Arr::get($config, 'convert.options', []);

        if (!is_a($convertClass, Converter::class, true)) {
            throw new InvalidArgumentException("Converter has wrong class [{$convertClass}].");
        }

        /** @psalm-suppress UndefinedClass */
        return new $class(
            /** @psalm-suppress UndefinedClass */
            new $pullClass(...$pullArgs),
            /** @psalm-suppress UndefinedClass */
            new $convertClass(...$convertArgs),
        );
    }

    /**
     * Get the provider configuration.
     */
    protected function getConfig(string $name): ?array
    {
        return $this->app['config']["services.jobs-feeds.{$name}"]
               ?? $this->app['config']["external-feed-parser.jobs-feeds.{$name}"];
    }
}
