<?php

namespace App\Http\Controllers;

use App\Models\Contradiction;
use App\Models\Disease;
use App\Models\DiseaseCategory;
use App\Models\DiseaseCategoryLanguage;
use App\Models\DiseaseLanguage;
use App\Models\Drug;
use App\Models\DrugCategory;
use App\Models\DrugCategoryLanguage;
use App\Models\Manufacturer;
use App\Models\ManufacturerLanguage;
use App\Models\SideEffect;
use Illuminate\Http\Request;

class DBTestController extends Controller
{
    public function index(){
//        $all = DiseaseCategory::all()->first();
//        $disease_lang = new DiseaseCategoryLanguage();
//        $disease_lang->title = 'abarvel';
//        $disease_lang->language = 3;
//        $disease_lang->disease_category_id = $all->id;
//        $disease_lang->save();
//        dd($all->disease_category_languages);

//          $all = DrugCategory::all()->first();
//          $drug_lang = new DrugCategoryLanguage();
//          $drug_lang->title = 'abarvel';
//          $drug_lang->language = 3;
//          $drug_lang->drug_category_id = $all->id;
//          $drug_lang->save();
//          dd($all->drug_category_languages);

//          $all = Manufacturer::all()->first();
//          $man_lang = new ManufacturerLanguage();
//          $man_lang->description = 'abarvel';
//          $man_lang->language = 3;
//          $man_lang->manufacturer_id = $all->id;
//          $man_lang->save();
//          dd($all);

//          $all = new Disease();
//          $all->disease_category_id = 1;
//          $all->save();
//          $disease_lang = new DiseaseLanguage();
//          $disease_lang->title = 'abarvel';
//          $disease_lang->description = 'abarvel';
//          $disease_lang->language = 3;
//          $disease_lang->disease_id = $all->id;
//          $disease_lang->save();
//          dd($all->disease_languages);

//          $all = Drug::all()->where('id',4)->first();
//          dd($all->drugs);

//          $all = Drug::all()->first();
//          dd($all->drug_titles);

//          $all = Drug::all()->where('id',5)->first();
//          dd($all->drug_images);

//          $all = SideEffect::all()->first();
//          dd($all->side_effect_languages->first()->side_effect);

//          $all = Drug::all()->where('id',10)->first();
//          dd($all->contradiction->contradiction_languages);

//          $all = Drug::all()->first();
//          dd($all->drug_reviews->first()->disease);

//          $all = Drug::all()->first();
//          if (!$all->manufacturers()->find(1)) {
//              $all->manufacturers()->attach(1);
//          }
//          dd($all->manufacturers()->find(1));

//          $all = Contradiction::all()->first();
//          if (!$all->diseases()->find(2)) {
//              $all->diseases()->attach(2);
//          }
//          dd($all->diseases);
    }
}
