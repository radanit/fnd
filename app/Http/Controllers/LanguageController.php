<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Http\FormRequest; 
use App;


class LanguageController extends Controller
{
    public function switchLang($lang)
    {
        if (array_key_exists($lang, Config::get('languages'))) {
            Session::put('applocale', $lang);
            App::setLocale(session('locale', $lang));
			config(['app.locale' => $lang]);
			config(['app.fallback_locale' => $lang]);
			//dd(config('app.locale'));
        }
        return Redirect::back();
        
    }
}
