<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class DetectLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (!App::isLocale(session('locale'))) {
            if (!in_array(session('locale'), [config('app.locale'), config('app.fallback_locale')])) {
                App::setLocale(session('locale'));
            } else {
                App::setLocale(config('app.fallback_locale'));
            }
        }

        return $next($request);
    }
}
