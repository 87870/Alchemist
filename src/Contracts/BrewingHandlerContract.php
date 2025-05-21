<?php

namespace MJ\Alchemist\Contracts;

use MJ\Alchemist\Context\BrewingContext;

interface BrewingHandlerContract
{
    public function brew(BrewingContext $context): array;
}