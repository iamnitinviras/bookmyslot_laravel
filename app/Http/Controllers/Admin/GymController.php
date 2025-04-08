<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GymRequest;
use App\Models\Gym;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class GymController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->user_type !== User::USER_TYPE_VENDOR) {
            return redirect('home');
        }

        $vendor_id = ($user->user_type == User::USER_TYPE_STAFF) ? $user->created_by : $user->id;
        $vendors = User::find($vendor_id);
        return view('admin.gym.create',compact('vendors'));
    }

    public function store(GymRequest $request)
    {
        try {
            $user = auth()->user();
            if ($user->user_type !== User::USER_TYPE_VENDOR) {
                return redirect('home');
            }

            DB::beginTransaction();
                Gym::updateOrCreate(['user_id'=>$user->id],[
                    'title'=>$request->title,
                    'email'=>$request->email,
                    'contact_person_name'=>$request->contact_person_name,
                    'contact_person_phone'=>$request->contact_person_phone,
                    'phone'=>$request->phone,
                    'website'=>$request->website,
                    'logo'=>$request->logo,
                ]);
            DB::commit();
            $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.gym.title')]));
        } catch (\Exception $ex) {
            DB::rollback();
            $request->session()->flash('Error', $ex->getMessage());
            return redirect()->back();
        }
        return redirect()->route('home');
    }
}
