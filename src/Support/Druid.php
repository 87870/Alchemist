<?php

namespace MJ\Alchemist\Support;

use Illuminate\Database\Eloquent\Collection as ECollection;
use Illuminate\Support\Collection as SCollection;
use Illuminate\Database\Eloquent\Model;
use MJ\Alchemist\Contracts\IngredientContract;
use MJ\Alchemist\Helpers\DecoratorHelper;
use ReflectionClass;
use ReflectionException;

/**
 * @internal
 * 
 */
final class Druid
{
    /**
     * @param ECollection|SCollection|Model|null $collection
     * @return array|null
     */
    public static function examine(ECollection|SCollection|Model|null $collection): ?array
    {
        if (!$collection)
            return null;

        # Checking if the given collection is one model.

        if ($collection instanceof Model)
            return [$collection, 'single'];

        # Should check that raw has at least one Model in the array to continue.

        if ($collection->isNotEmpty())
            return [$collection->first(), 'multiple'];

        return null;
    }

    /**
     * @throws ReflectionException
     */
    public static function extract(?Model $sample, array $ingredients): ?array
    {
        $reflection = new ReflectionClass($sample);

        $attributes = [];

        /**
         * @var IngredientContract[] $ingredients
         * @var IngredientContract $ingredient
         */
        foreach ($ingredients as $ingredient) {

            if (method_exists($ingredient, 'usesDecorator') and $ingredient::usesDecorator()) {

                $methodsNames = DecoratorHelper::getMethodsNamesByDecorator($ingredient::ingredientName(), $sample);

                $attributes = array_merge(
                    $attributes,
                    array_fill_keys($methodsNames, $ingredient)
                );

            } else {
                $attributes = array_merge(
                    $attributes,
                    array_fill_keys($reflection->getProperty($ingredient::ingredientName())->getValue($sample), $ingredient) ?? []
                );
            }
        }

        $formula = $sample::formula();

        return [$attributes, $formula];
    }
}