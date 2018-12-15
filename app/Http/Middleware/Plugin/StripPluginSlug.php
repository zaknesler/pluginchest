<?php

namespace App\Http\Middleware\Plugin;

use Closure;

class StripPluginSlug
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        abort_unless(optional($request->plugin)->slug == $request->plugin_slug, 404);

        $request->route()->forgetParameter('plugin_slug');

        return $next($request);
    }
}
