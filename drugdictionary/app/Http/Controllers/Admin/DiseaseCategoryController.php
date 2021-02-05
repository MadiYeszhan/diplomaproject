<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Disease;
use App\Models\DiseaseCategory;
use App\Models\DiseaseCategoryLanguage;
use Illuminate\Http\Request;

class DiseaseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $diseases = DiseaseCategory::all();
        $diseaseLanguages = DiseaseCategoryLanguage::all();
        return view('admin.DiseaseCategory.index', compact(['diseases','diseaseLanguages']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.DiseaseCategory.create');
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
            return redirect()->route('disease_categories.create')->with('error','You must fill in at least one language!!!');
        }
        else{
            $diseaseCategory = new DiseaseCategory();
            $diseaseCategory->save();
            if($title_eng != null){
                $langEng = new DiseaseCategoryLanguage();
                $langEng->language = 1;
                $langEng->title = $title_eng;
                $langEng->disease_category()->associate($diseaseCategory);
                $langEng->save();
            }

            if($title_rus != null){
                $langRus = new DiseaseCategoryLanguage();
                $langRus->language = 2;
                $langRus->title = $title_rus;
                $langRus->disease_category()->associate($diseaseCategory);
                $langRus->save();
            }

            if($title_kaz != null){
                $langKaz = new DiseaseCategoryLanguage();
                $langKaz->language = 3;
                $langKaz->title = $title_kaz;
                $langKaz->disease_category()->associate($diseaseCategory);
                $langKaz->save();
            }
            return redirect()->route('disease_categories.index')->with('success','DiseaseCategory is created.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DiseaseCategory  $diseaseCategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(DiseaseCategory $diseaseCategory)
    {
        return redirect()->route('disease_categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DiseaseCategory  $diseaseCategory
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(DiseaseCategory $diseaseCategory)
    {
        $title_eng = "";
        $title_rus = "";
        $title_kaz = "";
        $diseaseCatLanguages = DiseaseCategoryLanguage::all()->where('disease_category_id',$diseaseCategory->id);
        if($diseaseCatLanguages->where('language',1)->first() != null){
            $title_eng = $diseaseCatLanguages->where('language',1)->first()->title;
        }

        if($diseaseCatLanguages->where('language',2)->first() != null){
            $title_rus = $diseaseCatLanguages->where('language',2)->first()->title;
        }

        if($diseaseCatLanguages->where('language',3)->first() != null){
            $title_kaz = $diseaseCatLanguages->where('language',3)->first()->title;
        }
        return view('admin.DiseaseCategory.edit', compact(['diseaseCategory','title_eng','title_rus','title_kaz']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DiseaseCategory  $diseaseCategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, DiseaseCategory $diseaseCategory)
    {
        $title_eng = $request->input('title_eng');
        $title_rus = $request->input('title_rus');
        $title_kaz = $request->input('title_kaz');
        if ($title_eng == null and $title_rus == null and $title_kaz == null){
            return redirect()->route('disease_categories.edit')->with('error','You must fill in at least one language!!!');
        }
        else{
            $diseaseCatLanguages = DiseaseCategoryLanguage::all()->where('disease_category_id',$diseaseCategory->id);
            if($title_eng != null){
                if ($diseaseCatLanguages->where('language',1)->first() == null) {
                    $langEng = new DiseaseCategoryLanguage();
                    $langEng->language = 1;
                    $langEng->title = $title_eng;
                    $langEng->disease_category()->associate($diseaseCategory);
                    $langEng->save();
                }
                else{
                    $diseaseCatLanguages->where('language',1)->first()->title = $title_eng;
                    $diseaseCatLanguages->where('language',1)->first()->save();
                }
            }

            if($title_rus != null){
                if ($diseaseCatLanguages->where('language',2)->first() == null) {
                    $langRus = new DiseaseCategoryLanguage();
                    $langRus->language = 2;
                    $langRus->title = $title_rus;
                    $langRus->disease_category()->associate($diseaseCategory);
                    $langRus->save();
                }
                else{
                    $diseaseCatLanguages->where('language',2)->first()->title = $title_rus;
                    $diseaseCatLanguages->where('language',2)->first()->save();
                }
            }

            if($title_kaz != null){
                if ($diseaseCatLanguages->where('language',3)->first() == null) {
                    $langKaz = new DiseaseCategoryLanguage();
                    $langKaz->language = 3;
                    $langKaz->title = $title_kaz;
                    $langKaz->disease_category()->associate($diseaseCategory);
                    $langKaz->save();
                }
                else{
                    $diseaseCatLanguages->where('language',3)->first()->title = $title_kaz;
                    $diseaseCatLanguages->where('language',3)->first()->save();
                }
            }
            return redirect()->route('disease_categories.index')->with('success','Disease Category is updated.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DiseaseCategory  $diseaseCategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DiseaseCategory $diseaseCategory)
    {
        if ($diseaseCategory->diseases->first() != null){
            return redirect()->route('disease_categories.index')->with('success','DiseaseCategory is not deleted.');
        }
        else {
            $diseaseLanguages = DiseaseCategoryLanguage::all()->where('disease_category_id', $diseaseCategory->id);
            foreach ($diseaseLanguages as $lang) {
                $lang->delete();
            }
            $diseaseCategory->delete();
            return redirect()->route('disease_categories.index')->with('success', 'DiseaseCategory is deleted.');
        }
    }
}
