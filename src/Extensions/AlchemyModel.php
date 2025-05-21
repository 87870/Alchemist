<?php

namespace \Extensions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Serri\Alchemist\Concerns\HasAlchemyFormulas;
use Serri\Alchemist\Formulas\Formula;

class AlchemyModel extends Model
{
    use HasAlchemyFormulas;
}