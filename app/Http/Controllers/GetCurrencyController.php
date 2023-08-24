<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GetCurrencyController extends Controller
{
    public function index() {
        return response('Просто текст') -> header('content-type', 'text/plain');
    }
}
