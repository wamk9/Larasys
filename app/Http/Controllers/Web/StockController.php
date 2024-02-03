<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StockController extends Controller
{
    public function page()
    {
        return Inertia::render('Stocks/List');
    }
}
