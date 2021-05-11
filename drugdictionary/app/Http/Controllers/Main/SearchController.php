<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use App\Models\DrugLanguage;
use App\Models\DrugTitle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    public function searchText(Request $request)
    {
        $v = Validator::make($request->all(), [
            'search_drug' => 'required|min:3|max:255',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }
        else {
            $lang = null;
            if (Cookie::get('lang') == null) {
                $lang = 1;
            } else {
                $lang = intval(Cookie::get('lang'));
            }
            $search = $request->get('search_drug');
            $results = DB::table('drug_titles')
                ->leftJoin('drug_languages', function($join){
                    $join->on('drug_languages.drug_id', '=', 'drug_titles.drug_id');
                    $join->on('drug_languages.language','=','drug_titles.language');
                })
                ->where('drug_titles.language', '=', $lang)
                ->where(function ($query) use ($search) {
                    $query->where('drug_titles.title', 'LIKE', $search . '%')
                        ->orWhere('drug_languages.description', 'LIKE', '%' . $search . '%')
                        ->orWhere('drug_languages.composition', 'LIKE', '%' . $search . '%');
                })
                ->orderByRaw(
                    "case when `drug_titles`.`title` = '".$search."' then 0 else 1 end"
                )
                ->orderBy('weight')
                ->select('drug_titles.drug_id','drug_languages.language', 'drug_titles.title', 'drug_languages.description',
                    'drug_languages.composition', 'drug_titles.weight');
            $results = $results->get()->unique('drug_id');
            return view('main.search.drug_search_text', compact(['results']));
        }
    }

    public function searchDrugAlphabet($letter)
    {
            $lang = null;
            if (Cookie::get('lang') == null) {
                $lang = 1;
            } else {
                $lang = intval(Cookie::get('lang'));
            }
            $results = DB::table('drug_titles')
                ->where('drug_titles.language', '=', $lang)
                ->where('drug_titles.title', 'LIKE', $letter . '%')
                ->orderBy('drug_id')
                ->orderBy('weight')
                ->select('drug_titles.drug_id', 'drug_titles.title', 'drug_titles.weight');
            $results = $results->get()->unique('drug_id');
            $two_letters = DB::select('SELECT UPPER(LEFT(title, 2)) as letter FROM drug_titles where language = :lang ORDER BY `letter` ASC',['lang'=>$lang]);
            $letter = $letter[0];
            return view('main.search.drug_search_alphabet', compact(['results','two_letters','letter']));
    }

    public function searchDrugNumber()
    {
        $lang = null;
        if (Cookie::get('lang') == null) {
            $lang = 1;
        } else {
            $lang = intval(Cookie::get('lang'));
        }
        $results = DB::table('drug_titles')
            ->where('drug_titles.language', '=', $lang)
            ->where('drug_titles.title', 'regexp', '^[0-9]+')
            ->orderBy('drug_id')
            ->orderBy('weight')
            ->select('drug_titles.drug_id', 'drug_titles.title', 'drug_titles.weight');
        $results = $results->get()->unique('drug_id');
        return view('main.search.drug_search_alphabet', compact(['results']));
    }

    public function searchDiseaseText(Request $request)
    {
        $v = Validator::make($request->all(), [
            'search_disease' => 'required|min:1|max:255',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }
        else {
            $lang = null;
            if (Cookie::get('lang') == null) {
                $lang = 1;
            } else {
                $lang = intval(Cookie::get('lang'));
            }
            $search = $request->get('search_disease');
            $results = DB::table('disease_languages')
                ->where('disease_languages.language', '=', $lang)
                ->where(function ($query) use ($search) {
                    $query->where('disease_languages.title', 'LIKE', $search . '%')
                        ->orWhere('disease_languages.description', 'LIKE', '%' . $search . '%');
                })
                ->orderBy('disease_id');
            $results = $results->get()->unique('disease_id');
            return view('main.search.disease_search_text', compact(['results']));
        }
    }

    public function searchDiseaseAlphabet($letter)
    {
        $lang = null;
        if (Cookie::get('lang') == null) {
            $lang = 1;
        } else {
            $lang = intval(Cookie::get('lang'));
        }
        $results = DB::table('disease_languages')
            ->where('disease_languages.language', '=', $lang)
            ->where('disease_languages.title', 'LIKE', $letter . '%');
        $results = $results->get()->unique('disease_id');
        $two_letters = DB::select('SELECT UPPER(LEFT(title, 2)) as letter FROM disease_languages where language = :lang ORDER BY `letter` ASC',['lang'=>$lang]);
        $letter = $letter;
        return view('main.search.disease_search_alphabet', compact(['results','two_letters','letter']));
    }
}
