<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ApiConsumer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ApiConnection';
    }
}
