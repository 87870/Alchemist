<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Formulas Enabled
    |--------------------------------------------------------------------------
    |
    | This value will determine whether the formulas_folder_path should exist or not.
    |
    */

    'formulas_enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | Formulas Path Strategy.
    |--------------------------------------------------------------------------
    |
    | This value tells the alchemist where formulas should be defined, 'app' value implies that
    | Formulas folder will be looked up for in the app folder and any other formulas folder exist
    | otherwise will not be taken into consideration.
    | meanwhile, 'modules' implies that Formulas folder will not be in app folder, yet should exist in
    | modules folder in each of the module root path.
    |
    | values: [
    |   'app' => 'default laravel application',
    |   'modules' => 'nwidart/laravel-modules package required'
    | ]
    */

    'formulas_path_strategy' => 'app',

    /*
    |--------------------------------------------------------------------------
    | Formulas Folder Path
    |--------------------------------------------------------------------------
    |
    | This value will determine where the Formulas folder lives in your application codebase.
    |
    */

    'formulas_folder_path' => app_path('Formulas'),

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
        \MJ\Alchemist\Ingredients\FillableIngredient::class,
        \MJ\Alchemist\Ingredients\GuardedIngredient::class,
        \MJ\Alchemist\Ingredients\MutagenIngredient::class,
        \MJ\Alchemist\Ingredients\RelationIngredient::class,

        # Custom Ingredients goes here...
    ],

    /*
    |--------------------------------------------------------------------------
    | Mutagens Attribute Name
    |--------------------------------------------------------------------------
    |
    | This value determines the name of the attributes in the model class that holds an array of
    | the names of the custom functions you might want the alchemist to use in the brew.
    |
    */

    'mutagens_attribute_name' => 'mutagens'

];