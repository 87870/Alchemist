<?php

namespace MJ\Alchemist\Services;

use Illuminate\Database\Eloquent\Collection as ECollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as SCollection;
use MJ\Alchemist\Context\BrewingContext;
use MJ\Alchemist\Resolvers\BrewingHandlerResolver;
use MJ\Alchemist\Support\BrewingConfigLoader;
use MJ\Alchemist\Support\Druid;
use ReflectionException;

class Alchemist
{
    private array $configuration;
    private BrewingContext $context;

    public function brew(ECollection|SCollection|Model|null $collection): array
    {
        if (!$collection or (($collection instanceof ECollection or $collection instanceof SCollection) and $collection->isEmpty()))
            return [];

        # Load 'alchemist' configuration.
        $this->configuration = BrewingConfigLoader::load();

        # Init context.
        $this->context = $this->initContext($collection);

        # Resolve brewing handler.
        $handler = BrewingHandlerResolver::resolve($this->context->handler());

        # Apply handler and set it back to the context.
        $this->context->setDecoction($handler->brew($this->context));

        return $this->context->decoction();
    }

    /**
     * @throws ReflectionException
     */
    private function initContext(ECollection|SCollection|Model|null $collection): BrewingContext
    {

        # Define $sample + $handler.
        # TODO: null check.
        [$sample, $handler] = Druid::examine($collection);

        # Extract $attributes + $formula.
        [$attributes, $formula] = Druid::extract($sample, $this->configuration['ingredients']);

        return new BrewingContext(
            raw: $collection,
            ingredients: $this->configuration['ingredients'],
            attributes: $attributes,
            formula: $formula,
            handler: $handler,
            sample: $sample,
        );
    }
}