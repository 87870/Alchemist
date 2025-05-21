<?php

namespace MJ\Alchemist\Ingredients;

use MJ\Alchemist\Contracts\IngredientContract;
use MJ\Alchemist\Decorators\Relation;
use MJ\Alchemist\Helpers\DecoratorHelper;
use MJ\Alchemist\Services\Alchemist;

final class RelationIngredient implements IngredientContract
{
    public static function usesDecorator(): bool
    {
        return true;
    }

    public static function ingredientName(): string
    {
        return Relation::class;
    }

    public static function infuse(string $ingredient, mixed $brewing): array
    {
        $relationName = self::getRelationName($brewing, $ingredient);

        return [
            $ingredient => (new Alchemist())->brew($brewing->$relationName)
        ];
    }

    private static function getRelationName(mixed $brewing, string $relation): string
    {
        return DecoratorHelper::getMethodNameByDecorator(self::ingredientName(), $brewing, $relation);
    }
}