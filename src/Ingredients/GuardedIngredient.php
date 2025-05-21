<?php


namespace MJ\Alchemist\Ingredients;

use MJ\Alchemist\Contracts\IngredientContract;

final class GuardedIngredient implements IngredientContract
{

    public static function ingredientName(): string
    {
        return 'guarded';
    }

    public static function infuse(string $ingredient, mixed $brewing): array
    {
        return [
            $ingredient => $brewing[$ingredient]
        ];
    }
}