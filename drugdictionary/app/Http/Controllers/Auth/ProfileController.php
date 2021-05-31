<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Disease;
use App\Models\DiseaseLanguage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','verified']);
    }

    public function profile(){
        return view('auth.profile');
    }

    public function settings(){
        return view('auth.settings');
    }

    public function saveSettings(Request $request){
        $v = Validator::make($request->all(), [
            'password_actual' => 'required|min:1|max:255',
            'password_new' => 'nullable|min:1|max:255',
            'password_repeat' => 'nullable|min:1|max:255',
            'new_name' => 'nullable|min:1|max:255',
        ]);
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }
        else {
            $user = Auth::user();
            if (Hash::check($request->input('password_actual'), $user->password)) {
                $password_new = $request->input('password_new');
                $password_repeat = $request->input('password_repeat');
                $new_name = $request->input('new_name');
                if ($password_new != null){
                    if ($password_new == $password_repeat){
                        $user->password = Hash::make($password_new);
                        $user->save();
                    }
                    else{
                        return redirect()->back()->withErrors([__('message.password_repeat_bad')]);
                    }
                }

                if ($new_name != null){
                    $user->name = $new_name;
                }
                return redirect()->back()->with('success',__('message.settings_saved'));
            }
            else{
                return redirect()->back()->withErrors([__('message.password_actual_bad')]);
            }

            return view('auth.settings');
        }
    }

    public function disease_list(){
        $lang = null;
        if (Cookie::get('lang') == null) {
            $lang = 1;
        } else {
            $lang = intval(Cookie::get('lang'));
        }
        $diseases = DiseaseLanguage::all()->where('language','=',$lang);
        return view('auth.disease_list',compact(['diseases','lang']));
    }

    public function addDisease(Request $request){
        $user = Auth::user();
        if (!$user->diseases->contains($request->input('disease_id'))){
            $user->diseases()->attach($request->input('disease_id'));
        }
        return redirect()->route('profile.disease_list')->with('success','Disease added to user.');
    }

    public function removeDisease($disease_id){
        Auth::user()->diseases()->detach($disease_id);
        return redirect()->route('profile.disease_list')->with('success','Disease was detach from user.');
    }
}
