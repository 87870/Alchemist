<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Ingredients
    |--------------------------------------------------------------------------
    |
    | Defines the model properties where the alchemist should search for the
    | requested formula ingredients.
    |
    | Usage Example:
    |   formula: ['field_1', 'field_2', 'field_3', 'relation1', ...]
    |   ingredients: ['fillable', 'related']
    |
    | In this example, the alchemist will attempt to locate 'field_1', 'field_2',
    | 'field_3', and 'relation1' within the model's 'fillable' and 'related' attributes.
    |
    | Extendability:
    | Additional ingredients can be incorporated by either utilizing the
    | pre-defined Ingredients provided by the package or by creating custom
    | Ingredients. Please refer to the documentation for guidance on defining
    | custom Ingredients.
    |
    */

    'ingredients' => [
        \Serri\Alchemist\Ingredients\FillableIngredient::class,
        \Serri\Alchemist\Ingredients\GuardedIngredient::class,
        \Serri\Alchemist\Ingredients\MutagenIngredient::class,
        \Serri\Alchemist\Ingredients\RelationIngredient::class,

        # Custom Ingredients goes here...
    ]
];