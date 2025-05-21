<?php

namespace MJ\Alchemist\Decorators;

use Attribute as Decorator;

#[Decorator(Decorator::TARGET_METHOD | Decorator::TARGET_METHOD)]
final class Relation
{
    /**
     * @var string|null
     */
    public ?string $name;

    public function __construct(?string $name = null)
    {
        $this->name = $name;
    }
}