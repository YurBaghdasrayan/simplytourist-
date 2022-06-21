<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
//use PharIo\Manifest\Application;

class Locale
{
    public function __construct(Application $app, Request $request) {
        $this->app = $app;
        $this->request = $request;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $raw_locale = Cookie::get('locale');     # Если пользователь уже был на нашем сайте,
        # то в сессии будет значение выбранного им языка.

        if (in_array($raw_locale, Config::get('app.locales'))) {  # Проверяем, что у пользователя в сессии установлен доступный язык
            $locale = $raw_locale;                                # (а не какая-нибудь бяка)
        }                                                         # И присваиваем значение переменной $locale.
        else {
            //По умолчанию локаль на английском
            $locale = Config::get('app.locale');
            if(strlen($request->server('HTTP_ACCEPT_LANGUAGE'))>1){
                $userLangs = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
                if(in_array($userLangs,Config::get('app.locales'))) {
                    $locale=$userLangs;
                }
            }
        }

        $this->app->setLocale($locale);
//        \Illuminate\Support\Facades\App::setLocale($locale);                                  # Устанавливаем локаль приложения

        return $next($request);                                   # И позволяем приложению работать дальше
    }
}
