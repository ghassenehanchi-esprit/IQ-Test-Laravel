<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Laramin\Utility\Onumoti;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function __construct() {
        $this->middleware(function ($request, $next) {
            return $next($request);
        });

        $className = get_called_class();
    }
}
