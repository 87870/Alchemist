<?php

namespace MJ\Alchemist\Extensions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use MJ\Alchemist\Concerns\HasAlchemyFormulas;
use MJ\Alchemist\Formulas\Formula;

class AlchemyModel extends Model
{
    use HasAlchemyFormulas;
}