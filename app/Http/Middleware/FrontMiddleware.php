<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\helper;
use App\Models\Settings;
class FrontMiddleware
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
        // if the current host contains the website domain
        $host = $_SERVER['HTTP_HOST'];
        if ($host  ==  env('WEBSITE_HOST')) {
           
            $user = User::where('slug', $request->vendor)->first();
            helper::language($user->id);
            // date_default_timezone_set(@helper::appdata($user->id)->timezone);
          
            if ($request->vendor != "" || $request->vendor != null) {
                if (empty($user)) {
                    abort(404);
                }
                if (helper::appdata(@$user->id)->maintenance_mode == 1) {
                    return response(view('errors.maintenance'));
                }
                $checkplan = helper::checkplan($user->id, '3');
                $v = json_decode(json_encode($checkplan));
                if (@$v->original->status == 2) {
                    return response(view('errors.accountdeleted'));
                }
                if ($user->is_available == 2) {
                    return response(view('errors.accountdeleted'));
                }
            }
        }
        // if the current host doesn't contain the website domain (meaning, custom domain)
        else {
            // if the current package doesn't have 'custom domain' feature || the custom domain is not connected
            $settingdata = User::where('custom_domain', $host)->first();
            helper::language($settingdata->id);
            date_default_timezone_set(helper::appdata($settingdata->id)->timezone);
            if (@$settingdata->id != "" || @$settingdata->id != null) {
                $user = User::where('id', @$settingdata->id)->first();
                if (empty($user)) {
                    abort(404);
                }
                if (helper::appdata($user->id)->maintenance_mode == 1) {
                    return response(view('errors.maintenance'));
                }
                if ($user->is_available == 2) {
                    return response(view('errors.accountdeleted'));
                }
            }
        }
        return $next($request);
    }
}
