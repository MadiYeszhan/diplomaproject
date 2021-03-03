<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Disease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','verified']);
    }

    public function profile(){
        $diseases = Disease::all();
        return view('auth.profile',compact(['diseases']));
    }

    public function addDisease(Request $request){
        $user = Auth::user();
        if (!$user->diseases->contains($request->input('disease_id'))){
            $user->diseases()->attach($request->input('disease_id'));
        }
        return redirect()->route('profile')->with('success','Disease added to user.');
    }

    public function removeDisease($disease_id){
        Auth::user()->diseases()->detach($disease_id);
        return redirect()->route('profile')->with('success','Disease was detach from user.');
    }
}
