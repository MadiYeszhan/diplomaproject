<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\ModeratorCheck;
use App\Models\Contradiction;
use App\Models\ContradictionLanguage;
use App\Models\Disease;
use App\Models\DiseaseLanguage;
use App\Models\Drug;
use App\Models\DrugCategory;
use App\Models\DrugCategoryLanguage;
use App\Models\DrugImage;
use App\Models\DrugLanguage;
use App\Models\DrugTitle;
use App\Models\Manufacturer;
use App\Models\SideEffect;

use App\Models\SideEffectLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;



class DrugController extends Controller
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
        $drugs = Drug::orderByDesc('updated_at')->paginate(20);
        return view('admin.Drug.index', compact(['drugs']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $drugs = Drug::all();
        $drugCategories = DrugCategory::all();
        $diseaseArr = array();
        foreach (Disease::all() as $disease){
            $diseaseLang = $disease->disease_languages->sortBy('language');
            if($disease->disease_languages()->where('disease_id',$disease->id)->first() != null) {
                array_push($diseaseArr, ['tag' => $diseaseLang->first()->title,'value' => $disease->id]);
            }
        }
        return view('admin.Drug.create',compact(['diseaseArr','drugCategories','drugs']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(),$this->validationFill());
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }
        else{
            $drug = new Drug();
            $drug->drug_category_id = $request->input('drug_category');
            $drug->disease_id = $request->input('disease_id');
            $drug->drug_id = $request->input('drug_id');
            $drug->child_contradiction = !is_null($request->input('child_contradiction'));
            $drug->pregnancy_contradiction = !is_null($request->input('pregnancy_contradiction'));
            $drug->save();

            for($i = 1; $i < intval($request->input('drug_titles_count'))+1;$i++){
                $drugTitle = new DrugTitle();
                $drugTitle->language = $request->input('drug_title_language_'.$i);
                $drugTitle->title = $request->input('drug_title_text_'.$i);
                $drugTitle->weight= $request->input('drug_title_weight_'.$i);
                $drugTitle->drug()->associate($drug);
                $drugTitle->save();
            }

            for($i = 1; $i < intval($request->input('drug_images_count'))+1;$i++){
                $path = Storage::putFile('public/img', $request->file('drug_image_'.$i));
                $drugImage = new DrugImage();
                $drugImage->image_name = $path;
                $drugImage->drug()->associate($drug);
                $drugImage->save();
            }

            $sideEffect = new SideEffect();
            $sideEffect->drug()->associate($drug);
            $sideEffect->save();

            $contradiction = new Contradiction();
            $contradiction->drug()->associate($drug);
            $contradiction ->save();
            if (!is_null($request->input('contradiction_diseases'))) {
                foreach (explode(',', $request->input('contradiction_diseases')) as $disease){
                    $contradiction->diseases()->attach($disease);
                }
            }

            for ($i = 1; $i < 4; $i++){
                if (!is_null($request->input('description_'.$i)) or !is_null($request->input('composition_'.$i))
                    or !is_null($request->input('dosage_'.$i)) or !is_null($request->input('availability_'.$i))
                    or !is_null($request->input('special_instructions_'.$i))
                    or !is_null($request->input('drug_interaction_'.$i))
                ){
                    $lang = new DrugLanguage();
                    $lang->language = $i;
                    $lang->description = $request->input('description_'.$i);
                    $lang->composition = $request->input('composition_'.$i);
                    $lang->dosage = $request->input('dosage_'.$i);
                    $lang->availability = $request->input('availability_'.$i);
                    $lang->special_instructions = $request->input('special_instructions_'.$i);
                    $lang->drug_interaction = $request->input('drug_interaction_'.$i);
                    $lang->drug()->associate($drug);
                    $lang->save();
                }

                if(!is_null($request->input('side_description_'.$i))
                    or !is_null($request->input('side_general_'.$i))
                    or !is_null($request->input('side_doctor_attention_'.$i))
                ){
                    $sidelang = new SideEffectLanguage();
                    $sidelang->language = $i;
                    $sidelang->description = $request->input('side_description_'.$i);
                    $sidelang->general = $request->input('side_general_'.$i);
                    $sidelang->doctor_attention = $request->input('side_doctor_attention_'.$i);
                    $sidelang->side_effect()->associate($sideEffect);
                    $sidelang->save();
                }

                if (!is_null($request->input('contradiction_description_'.$i))){
                    $contLang = new ContradictionLanguage();
                    $contLang->language = $i;
                    $contLang->description = $request->input('contradiction_description_'.$i);
                    $contLang->contradiction()->associate($contradiction);
                    $contLang->save();
                }
            }
            return redirect()->route('drugs.index')->with('success','Drug is created.');
        }
    }

    private function validationFill(){
        $validArr = [
            "drug_category" => 'required',
            "disease_id" => 'required',
            "drug_id" => 'nullable',
            "drug_title_text_1" => 'required|max:255',
            "drug_title_weight_1" => 'required',
            "drug_title_language_1" => 'required',
            "drug_titles_count" => 'required',
        ];
        for ($i = 1; $i < 4;$i++){
            $validArr['side_description_'.$i] = 'nullable|max:65535';
            $validArr['side_general_'.$i] = 'nullable|max:65535';
            $validArr['side_doctor_attention_'.$i] = 'nullable|max:65535';
            $validArr['contradiction_description_'.$i] = 'nullable|max:65535';
            $validArr['contradiction_diseases_'.$i] = 'nullable|max:65535';
            $validArr['description_'.$i] = 'nullable|max:65535';
            $validArr['composition_'.$i] = 'nullable|max:65535';
            $validArr['dosage_'.$i] = 'nullable|max:65535';
            $validArr['availability_'.$i] = 'nullable|max:65535';
            $validArr['special_instructions_'.$i] = 'nullable|max:65535';
            $validArr['drug_interaction_'.$i] = 'nullable|max:65535';
        }
        return $validArr;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Drug  $drug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Drug $drug)
    {
        $drugs = Drug::all();
        $drugCategories = DrugCategory::all();
        $diseaseArr = array();
        foreach (Disease::all() as $disease){
            $diseaseLang = $disease->disease_languages->sortBy('language');
            if($disease->disease_languages()->where('disease_id',$disease->id)->first() != null) {
                array_push($diseaseArr, ['tag' => $diseaseLang->first()->title,'value' => $disease->id]);
            }
        }

        $manufacturerArr = array();
        foreach (Manufacturer::all() as $man){
                array_push($manufacturerArr, ['tag' => $man->title,'value' => $man->id]);
        }

        $diseaseContradiction = "";
        if ($drug->contradiction != null){
        foreach ($drug->contradiction->diseases as $disease){
            $diseaseContradiction .= $disease->id.',';
        }}
        $drugImagesSize = sizeof($drug->drug_images);
        return view('admin.Drug.edit',compact(['diseaseArr','drugCategories','drugs','drug','diseaseContradiction','drugImagesSize','manufacturerArr']));
    }

    public function destroyDrugTitle(DrugTitle $drugTitle)
    {
        $drugTitle->delete();
        return response()->json(['success' => 'Record deleted successfully!']);
    }

    public function destroyDrugImage(DrugImage $drugImage)
    {
        Storage::delete($drugImage->image_name);
        $drugImage->delete();
        return response()->json(['success' => 'Record deleted successfully!']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Drug  $drug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Drug $drug)
    {
        $v = Validator::make($request->all(),$this->validationFill());
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }
        else{
            $drug->drug_category_id = $request->input('drug_category');
            $drug->disease_id = $request->input('disease_id');
            $drug->drug_id = $request->input('drug_id');
            $drug->child_contradiction = !is_null($request->input('child_contradiction'));
            $drug->pregnancy_contradiction = !is_null($request->input('pregnancy_contradiction'));
            $drug->save();

            for($i = 1; $i < intval($request->input('drug_titles_count'))+1;$i++){
                if ($request->input('drug_title_id_'.$i) != null){
                    $drugTitle = DrugTitle::find($request->input('drug_title_id_'.$i));
                    $drugTitle->language = $request->input('drug_title_language_'.$i);
                    $drugTitle->title = $request->input('drug_title_text_'.$i);
                    $drugTitle->weight= $request->input('drug_title_weight_'.$i);
                    $drugTitle->save();
                }
                else {
                    $drugTitle = new DrugTitle();
                    $drugTitle->language = $request->input('drug_title_language_' . $i);
                    $drugTitle->title = $request->input('drug_title_text_' . $i);
                    $drugTitle->weight = $request->input('drug_title_weight_' . $i);
                    $drugTitle->drug()->associate($drug);
                    $drugTitle->save();
                }
            }

            for($i = 1; $i < intval($request->input('drug_images_count'))+1;$i++){
                $path = Storage::putFile('public/img', $request->file('drug_image_'.$i));
                $drugImage = new DrugImage();
                $drugImage->image_name = $path;
                $drugImage->drug()->associate($drug);
                $drugImage->save();
            }

            $sideEffect = $drug->side_effect;
            $contradiction = $drug->contradiction;
            $contradiction->diseases()->detach();

            if (!is_null($request->input('contradiction_diseases'))) {
                foreach (explode(',', $request->input('contradiction_diseases')) as $disease){
                    $contradiction->diseases()->attach($disease);
                }
            }

            if ($request->input('manufacturer_id') != -1) {
                $drug->manufacturers()->detach();
                $drug->manufacturers()->attach($request->input('manufacturer_id'));
            }
            else{
                $drug->manufacturers()->detach();
            }

            for ($i = 1; $i < 4; $i++){
                if (!is_null($request->input('description_'.$i)) or !is_null($request->input('composition_'.$i))
                    or !is_null($request->input('dosage_'.$i)) or !is_null($request->input('availability_'.$i))
                    or !is_null($request->input('special_instructions_'.$i))
                    or !is_null($request->input('drug_interaction_'.$i))
                ){
                    if ($drug->drug_languages->where('language',$i)->first() != null) {
                        $lang = $drug->drug_languages->where('language',$i)->first();
                        $lang->description = $request->input('description_' . $i);
                        $lang->composition = $request->input('composition_' . $i);
                        $lang->dosage = $request->input('dosage_' . $i);
                        $lang->availability = $request->input('availability_' . $i);
                        $lang->special_instructions = $request->input('special_instructions_' . $i);
                        $lang->drug_interaction = $request->input('drug_interaction_' . $i);
                        $lang->save();
                    }
                    else{
                        $lang = new DrugLanguage();
                        $lang->language = $i;
                        $lang->description = $request->input('description_' . $i);
                        $lang->composition = $request->input('composition_' . $i);
                        $lang->dosage = $request->input('dosage_' . $i);
                        $lang->availability = $request->input('availability_' . $i);
                        $lang->special_instructions = $request->input('special_instructions_' . $i);
                        $lang->drug_interaction = $request->input('drug_interaction_' . $i);
                        $lang->drug()->associate($drug);
                        $lang->save();
                    }
                }

                if(!is_null($request->input('side_description_'.$i))
                    or !is_null($request->input('side_general_'.$i))
                    or !is_null($request->input('side_doctor_attention_'.$i))
                ){
                    if ($sideEffect->side_effect_languages->where('language',$i)->first() != null){
                        $sidelang = $sideEffect->side_effect_languages->where('language',$i)->first();
                        $sidelang->description = $request->input('side_description_' . $i);
                        $sidelang->general = $request->input('side_general_' . $i);
                        $sidelang->doctor_attention = $request->input('side_doctor_attention_' . $i);
                        $sidelang->save();
                    }
                    else {
                        $sidelang = new SideEffectLanguage();
                        $sidelang->language = $i;
                        $sidelang->description = $request->input('side_description_' . $i);
                        $sidelang->general = $request->input('side_general_' . $i);
                        $sidelang->doctor_attention = $request->input('side_doctor_attention_' . $i);
                        $sidelang->side_effect()->associate($sideEffect);
                        $sidelang->save();
                    }
                }

                if (!is_null($request->input('contradiction_description_'.$i))){
                    if ($contradiction->contradiction_languages->where('language',$i)->first() != null) {
                        $contLang  = $contradiction->contradiction_languages->where('language',$i)->first();
                        $contLang->description = $request->input('contradiction_description_' . $i);
                        $contLang->save();
                    }
                    else{
                        $contLang = new ContradictionLanguage();
                        $contLang->language = $i;
                        $contLang->description = $request->input('contradiction_description_' . $i);
                        $contLang->contradiction()->associate($contradiction);
                        $contLang->save();
                    }
                }
            }
            return redirect()->route('drugs.index')->with('success','Drug is updated.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Drug  $drug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Drug $drug)
    {
        if ($drug->drugs->first() == null) {
            foreach ($drug->drug_languages as $lang) {
                $lang->delete();
            }

            foreach ($drug->drug_titles as $title) {
                $title->delete();
            }

            foreach ($drug->drug_images as $image) {
                Storage::delete($image->image_name);
                $image->delete();
            }

            foreach ($drug->side_effect->side_effect_languages as $sideLang) {
                $sideLang->delete();
            }

            foreach ($drug->contradiction->contradiction_languages as $contLang) {
                $contLang->delete();
            }

            foreach ($drug->drug_reviews() as $review) {
                $review->delete();
            }

            foreach ($drug->pharmacy_links() as $link) {
                $link->delete();
            }

            $drug->manufacturers()->detach();
            $drug->side_effect->delete();
            $drug->contradiction->delete();

            $drug->delete();
            return redirect()->route('drugs.index')->with('success','Drug is deleted.');
        }
        else{
            return redirect()->route('drugs.index')->with('success','Drug is not deleted.');
        }
    }
}
