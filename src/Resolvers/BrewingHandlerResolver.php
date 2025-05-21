<?php

namespace MJ\Alchemist\Resolvers;

use InvalidArgumentException;
use MJ\Alchemist\Contracts\BrewingHandlerContract;
use MJ\Alchemist\Handlers\MultipleBrewingHandler;
use MJ\Alchemist\Handlers\SingleBrewingHandler;

/**
 * @internal
 * 
 */
class BrewingHandlerResolver
{
    public static function resolve(string $handler): BrewingHandlerContract
    {
        return match ($handler) {
            'single' => new SingleBrewingHandler(),
            'multiple' => new MultipleBrewingHandler(),
            default => throw new InvalidArgumentException("Unknown brewing handler: $handler"),
        };
    }
}