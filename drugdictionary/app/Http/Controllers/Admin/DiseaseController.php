<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\ModeratorCheck;
use App\Models\Disease;
use App\Models\DiseaseCategory;
use App\Models\DiseaseCategoryLanguage;
use App\Models\DiseaseLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiseaseController extends Controller
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
        $diseases = Disease::all();
        $diseaseLanguages = DiseaseLanguage::all()->sortBy('language');
        return view('admin.Disease.index', compact(['diseases','diseaseLanguages']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $diseaseCategories = DiseaseCategory::all();
        $diseaseCatLang = DiseaseCategoryLanguage::all()->sortBy('language');
        return view('admin.Disease.create',compact(['diseaseCategories','diseaseCatLang']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'disease_category_id' => 'required',
            'title_1' => 'max:255',
            'title_2' => 'max:255',
            'title_3' => 'max:255',
            'description_1' => 'nullable|max:65535',
            'description_2' => 'nullable|max:65535',
            'description_3' => 'nullable|max:65535',
        ]);
        if($v->fails() or ($request->input('title_1') == null and $request->input('title_2') == null
            and $request->input('title_3') == null)
        ){
            if ($v->fails()) {
                return redirect()->back()->withErrors($v->errors());
            }
            else{
                return redirect()->back()->withErrors(['Title error:',
                    'At least one title must be completed in any language']);
            }
        }
        else{
            $disease = new Disease();
            $disease->disease_category_id = $request->input('disease_category_id');
            $disease->save();

            for ($i = 1; $i < 4; $i++){
                    $lang = new DiseaseLanguage();
                    $lang->language = $i;
                    $lang->title = $request->input('title_'.$i);
                    $lang->description = $request->input('description_'.$i);
                    $lang->disease()->associate($disease);
                    $lang->save();
            }
            return redirect()->route('diseases.index')->with('success','Disease is created.');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Disease  $disease
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Disease $disease)
    {
        $diseaseCategories = DiseaseCategory::all();
        $diseaseCatLang = DiseaseCategoryLanguage::all()->sortBy('language');
        $diseaseArr = [
            1 => ['title' => '', 'description' => ''],
            2 => ['title' => '', 'description' => ''],
            3 => ['title' => '', 'description' => ''],
        ];
        $diseaseLang = DiseaseLanguage::all()->where('disease_id',$disease->id);
        for ($i = 1; $i < 4; $i++){
            if ($diseaseLang->where('language',$i)->first() != null){
                $diseaseArr[$i]['title'] = $diseaseLang ->where('language',$i)->first()->title;
                $diseaseArr[$i]['description'] = $diseaseLang ->where('language',$i)->first()->description;
            }
        }
        return view('admin.Disease.edit',compact(['diseaseCategories','diseaseCatLang','disease','diseaseArr']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Disease  $disease
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Disease $disease)
    {
        $v = Validator::make($request->all(), [
            'disease_category_id' => 'required',
            'title_1' => 'max:255',
            'title_2' => 'max:255',
            'title_3' => 'max:255',
            'description_1' => 'nullable|max:65535',
            'description_2' => 'nullable|max:65535',
            'description_3' => 'nullable|max:65535',
        ]);
        if($v->fails() or ($request->input('title_1') == null and $request->input('title_2') == null
                and $request->input('title_3') == null)
        ){
            if ($v->fails()) {
                return redirect()->back()->withErrors($v->errors());
            }
            else{
                return redirect()->back()->withErrors(['Title error:',
                    'At least one title must be completed in any language']);
            }
        }
        else{
            $disease->disease_category_id = $request->input('disease_category_id');
            $disease->save();
            $diseaseLang = DiseaseLanguage::all()->where('disease_id', $disease->id);
            for ($i = 1; $i < 4; $i++){
                if ($diseaseLang->where('language', $i)->first() != null){
                    $diseaseLang->where('language', $i)->first()->title = $request->input('title_' . $i);
                    $diseaseLang->where('language', $i)->first()->description = $request->input('description_' . $i);
                    $diseaseLang->where('language', $i)->first()->save();
                }
                else{
                    $lang = new DiseaseLanguage();
                    $lang->language = $i;
                    $lang->title = $request->input('title_'.$i);
                    $lang->description = $request->input('description_'.$i);
                    $lang->disease()->associate($disease);
                    $lang->save();
                }
            }
            return redirect()->route('diseases.index')->with('success','Disease is updated.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Disease  $disease
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Disease $disease)
    {
        $diseaseLanguages = diseaseLanguage::all()->where('disease_id',$disease->id);
        foreach ($diseaseLanguages as $lang){
            $lang->delete();
        }
        $disease->delete();
        return redirect()->route('diseases.index')->with('success','Disease is deleted.');
    }
}
