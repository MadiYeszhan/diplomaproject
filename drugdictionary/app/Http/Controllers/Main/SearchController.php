<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Contradiction;
use App\Models\Drug;
use App\Models\DrugCategory;
use App\Models\DrugCategoryLanguage;
use App\Models\DrugLanguage;
use App\Models\DrugTitle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    const alphabetArrEng = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
    const alphabetArrRus = ['А','Б','В','Г','Д','Е','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Э','Ю','Я'];
    const alphabetArrKaz = ['А','Б','В','Г','Д','Е','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Э','Ю','Я'];

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
                    "case when `drug_titles`.`title` LIKE '%".$search."%' then 0 else 1 end"
                )
                ->orderBy('weight');
            $results->select('drug_titles.drug_id','drug_languages.language', 'drug_titles.title', 'drug_languages.description',
                    'drug_languages.composition', 'drug_titles.weight');
            $results = $results->get()->unique('drug_id')->paginate(10);
            $user_disease = null;
            if (!Auth::guest()){
                if (Auth::user()->diseases->first() != null)
                {
                    $user_disease = Auth::user()->diseases;
                }
            }


            return view('main.search.drug_search_text', compact(['results','search','user_disease']));
        }
    }

    public function searchDrugAlphabet($letter)
    {
            //Alphabet for search
            $alphabetArr = self::alphabetArrEng;
            if (Cookie::get('lang') == 2){
                $alphabetArr = self::alphabetArrRus;
            }
            else if (Cookie::get('lang') == 3){
                $alphabetArr = self::alphabetArrKaz;
            }

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
            $results = $results->get()->unique('drug_id')->paginate(20);
            $two_letters = DB::select('SELECT UPPER(LEFT(title, 2)) as letter FROM drug_titles where language = :lang ORDER BY `letter` ASC',['lang'=>$lang]);
            if ($lang == 1)
                $letter = substr($letter, 0, 1);
            else{
                $letter = substr($letter, 0, 2);
            }
            return view('main.search.drug_search_alphabet', compact(['results','two_letters','letter','lang','alphabetArr']));
    }

    public function searchDrugNumber()
    {
        //Alphabet for search
        $alphabetArr = self::alphabetArrEng;
        if (Cookie::get('lang') == 2){
            $alphabetArr = self::alphabetArrRus;
        }
        else if (Cookie::get('lang') == 3){
            $alphabetArr = self::alphabetArrKaz;
        }

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
        $results = $results->get()->unique('drug_id')->paginate(20);
        return view('main.search.drug_search_alphabet', compact(['results','alphabetArr']));
    }

    public function searchDrugCat($category)
    {
            $lang = null;
            if (Cookie::get('lang') == null) {
                $lang = 1;
            } else {
                $lang = intval(Cookie::get('lang'));
            }

            $results = DB::table('drug_titles')
                ->join('drugs','drug_titles.drug_id','=','drugs.id')
                ->where('drug_titles.language', '=', $lang)
                ->where('drugs.drug_category_id', '=', $category)
                ->orderBy('weight');
            $results = $results->get()->unique('id')->paginate(20);
            $drugCats = DrugCategoryLanguage::all()->where('language','=',Cookie::get('lang'));
            return view('main.search.drug_search_cat', compact(['results','drugCats']));
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
            $results = $results->get()->unique('disease_id')->paginate(10);
            return view('main.search.disease_search_text', compact(['results','search']));
        }
    }

    public function searchTextSide(Request $request)
    {
        $v = Validator::make($request->all(), [
            'search_side' => 'required|min:3|max:255',
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
            $search = $request->get('search_side');
            $results = DB::table('drug_titles')
                ->where('drug_titles.language', '=', $lang)
                ->where(function ($query) use ($search) {
                    $query->where('drug_titles.title', 'LIKE', $search . '%');
                })
                ->orderByRaw(
                    "case when `drug_titles`.`title` = '".$search."' then 0 else 1 end"
                )
                ->orderBy('weight');
            $results->select('drug_titles.drug_id','drug_titles.title','drug_titles.weight');
            $results = $results->get()->unique('drug_id')->paginate(10);
            return view('main.search.side_search_text', compact(['results','search']));
        }
    }
}
