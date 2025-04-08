<?php

namespace App\Http\Middleware;

use App\Models\Branch;
use App\Models\Gym;
use App\Models\User;
use App\Models\VendorSetting;
use Closure;
use Illuminate\Http\Request;

class VendorSettingMiddleware
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
        $vendorSetting = null;
        $user=auth()->user();

        if (auth()->user()->user_type == User::USER_TYPE_VENDOR) {
            $vendorSetting = VendorSetting::where('user_id', auth()->user()->id)->first();
            $created_by = auth()->user()->id;

            $gym_count=Gym::where('user_id',$created_by)->count();
            if ($gym_count==0){
                return redirect()->route('admin.gym.index');
            }
        }elseif(auth()->user()->user_type == User::USER_TYPE_STAFF) {
            $vendorSetting = VendorSetting::where('user_id', auth()->user()->created_by)->first();
            $created_by = auth()->user()->created_by;
        }
        $total_branch_count = Branch::where('user_id', $created_by)->count();
        if ($total_branch_count == 0) {
            return redirect()->route('home');
        }

        config(['vendor_setting' => $vendorSetting]);
        return $next($request);
    }
}
