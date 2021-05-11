<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use App\Models\DrugCategory;
use App\Models\DrugCategoryLanguage;
use App\Models\Mute;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        //main admin page
        return view('admin.index');
    }

    public function showUsers()
    {
        //shows list of users
        $users = User::orderByDesc('updated_at')->paginate(20);
        return view('admin.users', compact(['users']));
    }

    public function muteUser(Request $request)
    {
        //validate inputs from form
        $v = Validator::make($request->all(), [
            'datetime' => 'required',
            'user_id' => 'required',
        ]);

        //if validation fails return with list of errors
        if ($v->fails()){
            return redirect()->back()->withErrors($v->errors());
        }
        else {
            //create user and carbon objects to check time and mute
            $user = User::find($request->input('user_id'));
            $now = Carbon::now();
            $mute_time = Carbon::parse($request->input('datetime'));
            //if current time on server less or equal than mute time then mute can be added
            if ($mute_time->gte($now)) {
                //if user hasn't mute then create a new one
                if ($user->mute == null){
                    $mute = new Mute();
                    $mute->user_id = $user->id;
                    $mute->mute_time = $mute_time->toDate();
                    $mute->save();
                }
                //else change time of current user mute
                else{
                    $user->mute->mute_time = $mute_time->toDate();
                    $user->mute->save();
                }
                return redirect()->back()->with('success', 'User is mute.');
            }
            //else mute will be deleted from account if mute exists
            else{
                if ($user->mute != null){
                    $user->mute()->delete();
                }
                return redirect()->back()->with('success', 'User is unmute.');
            }
        }
    }

    public function destroyUser(User $user)
    {
        //delete users from DB
        if ($user->id != null) {
            $user->diseases()->detach();
            $user->roles()->detach();
            $user->mute()->delete();
            $user->delete();
            return redirect()->back()->with('success', 'User is deleted.');
        }
        else{
            return redirect()->back()->with('success', 'User is not deleted.');
        }
    }
}
