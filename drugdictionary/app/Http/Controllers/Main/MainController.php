<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Disease;
use App\Models\Drug;
use App\Models\DrugCategory;
use App\Models\DrugCategoryLanguage;
use App\Models\DrugReview;
use App\Models\DrugTitle;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Collection;

class MainController extends Controller
{

    const alphabetArrEng = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
    const alphabetArrRus = ['А','Б','В','Г','Д','Е','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Э','Ю','Я'];
    const alphabetArrKaz = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];


    //Index and Sections pages
    public function index()
    {
        //Alphabet for search
        $alphabetArr = self::alphabetArrEng;
        if (Cookie::get('lang') == 2){
            $alphabetArr = self::alphabetArrRus;
        }
        else if (Cookie::get('lang') == 3){
            $alphabetArr = self::alphabetArrKaz;
        }

        return view('main.index',compact('alphabetArr'));
    }

    public function pharmacies()
    {
        return view('main.pharmacy');
    }

    public function contacts()
    {
        return view('main.contacts');
    }

    public function about()
    {
        return view('main.about');
    }

    public function drugs()
    {
        //Alphabet for search
        $alphabetArr = self::alphabetArrEng;
        if (Cookie::get('lang') == 2){
            $alphabetArr = self::alphabetArrRus;
        }
        else if (Cookie::get('lang') == 3){
            $alphabetArr = self::alphabetArrKaz;
        }

        $lang = Cookie::get('lang');

        $drugs = DrugTitle::orderBy('weight')->where('language','=',Cookie::get('lang'))->get()->unique('drug_id')->paginate(20);
        $drugCats = DrugCategoryLanguage::all()->where('language','=',Cookie::get('lang'));
        $manufacturers = Manufacturer::all()->forPage(1,10);
        $rating = DB::table('drug_reviews')->where('language','=',Cookie::get('lang'))->selectRaw('drug_id, sum(rating)')->groupBy('drug_id');
        return view('main.section.drug',compact(['alphabetArr','drugs','drugCats','manufacturers','rating','lang']));
    }

    public function diseases()
    {
        //Alphabet for search
        $alphabetArr = self::alphabetArrEng;
        return view('main.diseases',compact('alphabetArr'));
    }

    public function changeLanguage($lang)
    {
        if ($lang < 1 and  $lang > 3 ) {
            return redirect()->back()->withErrors();
        }
        else{
            if ($lang == 1)
                Cookie::queue('lang', 1, 60 * 60 * 30);
            else if ($lang == 2)
                Cookie::queue('lang', 2, 60 * 60 * 30);
            else if ($lang == 3)
                Cookie::queue('lang', 3, 60 * 60 * 30);
            return redirect()->route('main.index');
        }
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
            $pharmacies = collect();
            $drugLanguage = $drug->drug_languages->where('language', $lang)->first();

            if (sizeof($drug->pharmacy_links) > 0){
                $parse = new ParseController();
                foreach ($drug->pharmacy_links as $pharmacy){
                    $pharmacy_return = null;
                    switch ($pharmacy->pharmacy_number){
                        case 1:
                            $pharmacy_return = $parse->parseAptekaPlus($pharmacy->link);
                            break;
                        case 2:
                            $pharmacy_return = $parse->parseBiosfera($pharmacy->link);
                            break;
                        case 3:
                            $pharmacy_return = $parse->parseEuropharma($pharmacy->link);
                            break;
                        case 4:
                            $pharmacy_return = $parse->parseTalap($pharmacy->link);
                            break;
                        case 5:
                            $pharmacy_return = $parse->parseEvcalyptus($pharmacy->link);
                            break;
                        default:
                    }
                    if ($pharmacy_return != null){
                        $pharmacies->push($pharmacy_return);
                    }
                }
                $pharmacies = $pharmacies->sortBy(['available','price']);
            }

            return view('main.details.drug', compact(['drug', 'lang', 'drugLanguage','pharmacies']));
        }
        else {
            return redirect()->back();
        }
    }

    public function createComment($id)
    {
        if (!Auth::guest()) {
            $lang = null;
            if (Cookie::get('lang') == null) {
                $lang = 1;
            } else {
                $lang = intval(Cookie::get('lang'));
            }
            $diseases = Disease::all();
            $drug = Drug::find($id);
            return view('main.comment', compact(['diseases', 'drug', 'lang']));
        }
        else{
            return redirect()->back();
        }
    }

    public function storeComment(Request $request)
    {
        $v = Validator::make($request->all(), [
            'drug_id' => 'required|integer',
            'lang' => 'required|integer|max:3|min:1',
            'disease_id' => 'required|integer',
            'comment' => 'required|min:1|max:32000',
            'rating' => 'required|numeric|max:10|min:0',
        ]);
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }
        else {
            if (!Auth::guest()) {
                $drug_review = new DrugReview();
                $drug_review->drug_id = $request->input('drug_id');
                $drug_review->disease_id = $request->input('disease_id');
                $drug_review->language = $request->input('lang');
                $drug_review->comment = $request->input('comment');
                $drug_review->rating = $request->input('rating');
                $drug_review->user_id = Auth::user()->id;
                $drug_review->save();

                return redirect()->route('main.drugs.details',$request->input('drug_id'))->with('success', 'Review is added.');
            }
            else{
                return redirect()->back();
            }
        }
    }

    public function deleteComment($id)
    {
        $drug_review = DrugReview::find($id);
        if (!Auth::guest() and $drug_review != null) {
            $user = Auth::user();
            $drug_id = $drug_review->drug_id;
            if ($user->roles->contains(2) or $user->id == $drug_review->user_id) {
                $drug_review->delete();
                return redirect()->route('main.drugs.details', $drug_id)->with('success', 'Review is deleted.');
            }
        }
        return redirect()->back();
    }


}
