<?php

namespace App\Radan\Http\Controllers;

use App;
use Config;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
    public function switchLang($lang)
    {
        if (array_key_exists($lang, Config::get('languages'))) {
            Session::put('applocale', $lang);
            App::setLocale(session('locale', $lang));
			config(['app.locale' => $lang]);
			config(['app.fallback_locale' => $lang]);			
        }
        return Redirect::back();
        
    }

    public function getLangResource()
    {
        $strings = Cache::pull('lang.js', function () {
            $lang = config('app.locale');
    
            $files   = glob(resource_path('lang/' . $lang . '/*.php'));
            $strings = [];
    
            foreach ($files as $file) {
                $name           = basename($file, '.php');
                $strings[$name] = require $file;
            }
    
            return $strings;
        });

        header('Content-Type: text/javascript');
        echo('window.i18n = ' . json_encode($strings) . ';');
        exit();
    }
}
