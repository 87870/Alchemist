<?php


namespace MJ\Alchemist\Ingredients;

use Closure;
use MJ\Alchemist\Contracts\IngredientContract;
use MJ\Alchemist\Decorators\Mutagen;
use MJ\Alchemist\Helpers\DecoratorHelper;
use ReflectionClass;

final class MutagenIngredient implements IngredientContract
{
    public static function usesDecorator(): bool
    {
        return true;
    }

    public static function ingredientName(): string
    {
        return Mutagen::class;
    }

    public static function infuse(string $ingredient, mixed $brewing): array
    {
        $mutagenInteraction = self::getMutagenPropertyClosure($brewing, $ingredient);

        return [
            $ingredient => $mutagenInteraction()
        ];
    }

    private static function getMutagenPropertyClosure(mixed $brewing, string $mutagen): Closure
    {
        $mutagensMethodName = DecoratorHelper::getMethodNameByDecorator(self::ingredientName(), $brewing, $mutagen);

        return (new ReflectionClass($brewing))
            ->getMethod($mutagensMethodName)
            ->getClosure($brewing);
    }
}