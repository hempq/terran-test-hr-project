<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App;
use Locale;
use Request;

class Language
{

    /**
     * The availables languages.
     *
     * @array $languages
     */
    protected $languages = ['en'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = Locale::acceptFromHttp(Request::server('HTTP_ACCEPT_LANGUAGE'));
        $language = 'en';

        App::setLocale($language);

        return $next($request);
    }
}
