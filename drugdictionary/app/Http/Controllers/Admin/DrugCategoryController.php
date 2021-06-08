<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\ModeratorCheck;
use App\Models\DrugCategory;
use App\Models\DrugCategoryLanguage;
use Illuminate\Http\Request;

class DrugCategoryController extends Controller
{

    public function __construct(){
        $this->middleware([ModeratorCheck::class]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $drugs = DrugCategory::all();
        $drugLanguages = DrugCategoryLanguage::all();
        return view('admin.DrugCategory.index', compact(['drugs','drugLanguages']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.DrugCategory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $title_eng = $request->input('title_eng');
        $title_rus = $request->input('title_rus');
        $title_kaz = $request->input('title_kaz');
        if ($title_eng == null and $title_rus == null and $title_kaz == null){
            return redirect()->route('drug_categories.create')->with('error','You must fill in at least one language!!!');
        }
        else{
            $drugCategory = new DrugCategory();
            $drugCategory->save();
            if($title_eng != null){
                $langEng = new DrugCategoryLanguage();
                $langEng->language = 1;
                $langEng->title = $title_eng;
                $langEng->drug_category()->associate($drugCategory);
                $langEng->save();
            }

            if($title_rus != null){
                $langRus = new DrugCategoryLanguage();
                $langRus->language = 2;
                $langRus->title = $title_rus;
                $langRus->drug_category()->associate($drugCategory);
                $langRus->save();
            }

            if($title_kaz != null){
                $langKaz = new DrugCategoryLanguage();
                $langKaz->language = 3;
                $langKaz->title = $title_kaz;
                $langKaz->drug_category()->associate($drugCategory);
                $langKaz->save();
            }

            return redirect()->route('drug_categories.index')->with('success','DrugCategory is created.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DrugCategory  $drugCategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(DrugCategory $drugCategory)
    {
        return redirect()->route('drug_categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DrugCategory  $drugCategory
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(DrugCategory $drugCategory)
    {
        $title_eng = "";
        $title_rus = "";
        $title_kaz = "";
        $drugCatLanguages = DrugCategoryLanguage::all()->where('drug_category_id',$drugCategory->id);
        if($drugCatLanguages->where('language',1)->first() != null){
            $title_eng = $drugCatLanguages->where('language',1)->first()->title;
        }

        if($drugCatLanguages->where('language',2)->first() != null){
            $title_rus = $drugCatLanguages->where('language',2)->first()->title;
        }

        if($drugCatLanguages->where('language',3)->first() != null){
            $title_kaz = $drugCatLanguages->where('language',3)->first()->title;
        }
        return view('admin.DrugCategory.edit', compact(['drugCategory','title_eng','title_rus','title_kaz']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DrugCategory  $drugCategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, DrugCategory $drugCategory)
    {
        $title_eng = $request->input('title_eng');
        $title_rus = $request->input('title_rus');
        $title_kaz = $request->input('title_kaz');
        if ($title_eng == null and $title_rus == null and $title_kaz == null){
            return redirect()->route('drug_categories.edit')->with('error','You must fill in at least one language!!!');
        }
        else{
            $drugCatLanguages = DrugCategoryLanguage::all()->where('drug_category_id',$drugCategory->id);
            if($title_eng != null){
                if ($drugCatLanguages->where('language',1)->first() == null) {
                    $langEng = new DrugCategoryLanguage();
                    $langEng->language = 1;
                    $langEng->title = $title_eng;
                    $langEng->drug_category()->associate($drugCategory);
                    $langEng->save();
                }
                else{
                    $drugCatLanguages->where('language',1)->first()->title = $title_eng;
                    $drugCatLanguages->where('language',1)->first()->save();
                }
            }

            if($title_rus != null){
                if ($drugCatLanguages->where('language',2)->first() == null) {
                    $langRus = new DrugCategoryLanguage();
                    $langRus->language = 2;
                    $langRus->title = $title_rus;
                    $langRus->drug_category()->associate($drugCategory);
                    $langRus->save();
                }
                else{
                    $drugCatLanguages->where('language',2)->first()->title = $title_rus;
                    $drugCatLanguages->where('language',2)->first()->save();
                }
            }

            if($title_kaz != null){
                if ($drugCatLanguages->where('language',3)->first() == null) {
                    $langKaz = new DrugCategoryLanguage();
                    $langKaz->language = 3;
                    $langKaz->title = $title_kaz;
                    $langKaz->drug_category()->associate($drugCategory);
                    $langKaz->save();
                }
                else{
                    $drugCatLanguages->where('language',3)->first()->title = $title_kaz;
                    $drugCatLanguages->where('language',3)->first()->save();
                }
            }
            return redirect()->route('drug_categories.index')->with('success','DrugCategory is updated.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DrugCategory  $drugCategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DrugCategory $drugCategory)
    {
        $drugLanguages = DrugCategoryLanguage::all()->where('drug_category_id',$drugCategory->id);
        foreach ($drugLanguages as $lang){
            $lang->delete();
        }
        $drugCategory->delete();
        return redirect()->route('drug_categories.index')->with('success','DrugCategory is deleted.');
    }
}
