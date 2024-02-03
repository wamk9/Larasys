<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api;
use Inertia\Inertia;

class MaterialController extends Api\MaterialController
{
    public function page()
    {
        return Inertia::render('Materials/List');
    }
}
