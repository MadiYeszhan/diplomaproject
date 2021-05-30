<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Disease;
use App\Models\DiseaseLanguage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

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
