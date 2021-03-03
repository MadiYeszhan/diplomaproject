<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class MainController extends Controller
{
    //Index and Sections pages
    public function index()
    {
        //Alphabet for search
        $alphabetArr = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        return view('main.index',compact('alphabetArr'));
    }

    public function drugs()
    {
        //Alphabet for search
        $alphabetArr = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        return view('main.index',compact('alphabetArr'));
    }

    public function diseases()
    {
        //Alphabet for search
        $alphabetArr = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        return view('main.diseases',compact('alphabetArr'));
    }

    //Details pages
    public function drug($id)
    {
        $lang = null;
        if (Cookie::get('lang') == null) {
            $lang = 1;
        } else {
            $lang = intval(Cookie::get('lang'));
        }

        $drug = Drug::find($id);
        if ($drug != null) {
            $drugLanguage = $drug->drug_languages->where('language', $lang)->first();
            return view('main.details.drug', compact(['drug', 'lang', 'drugLanguage']));
        }
        else {
            return redirect()->back();
        }
    }
}
