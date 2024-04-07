<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\helper;
class landingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!file_exists(storage_path() . "/installed")) {
            return redirect('install');
            exit;
        }
        // Get default language from admin 
        date_default_timezone_set(helper::appdata(1)->timezone);
        helper::language(1);
        $user = User::where('id',1)->first();
        if (@helper::appdata($user->id)->maintenance_mode == 1) {
            return response(view('errors.maintenance'));
        }
        return $next($request);
    }
}
