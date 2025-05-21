<?php

namespace MJ\Alchemist\Facades;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;


/**
 * @method static array brew(\Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection|Model|null $collection)
 */
class Alchemist extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'Alchemist';
    }
}