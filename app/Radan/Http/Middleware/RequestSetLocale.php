<?php

namespace App\Radan\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class RequestSetLocale
{
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('applocale') && array_key_exists(Session::get('applocale'), config('languages'))) {
            App::setLocale(Session::get('applocale'));
            config(['app.locale' => Session::get('applocale')]);
			config(['app.fallback_locale' => Session::get('applocale')]);
        }
        else {
			// This is optional as Laravel will automatically set the fallback language if there is none specified
            App::setLocale(config('app.fallback_locale'));
        }
        return $next($request);
    }
}