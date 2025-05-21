<?php

namespace MJ\Alchemist\Handlers;

use MJ\Alchemist\Context\BrewingContext;
use MJ\Alchemist\Contracts\BrewingHandlerContract;

/**
 * @internal
 * 
 */
class SingleBrewingHandler implements BrewingHandlerContract
{

    public function brew(BrewingContext $context): array
    {
        $decoction = [];

        foreach ($context->formula() as $element) {
            $decoction = array_merge(
                $decoction,
                AttributeBrewingHandler::brew($context, $context->raw(), $element)
            );
        }

        return $decoction;
    }
}