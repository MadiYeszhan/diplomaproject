<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\ModeratorCheck;
use App\Models\Manufacturer;
use App\Models\ManufacturerLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManufacturerController extends Controller
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
        $manufacturers = Manufacturer::all();
        return view('admin.Manufacturer.index', compact(['manufacturers']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.Manufacturer.create');
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
            'title' => 'required|min:1|max:255',
            'year_foundation' => 'nullable|integer',
            'year_termination' => 'nullable|integer',
            'description_1' => 'nullable|max:65535',
            'description_2' => 'nullable|max:65535',
            'description_3' => 'nullable|max:65535',
        ]);

        if ($v->fails()){
            return redirect()->back()->withErrors($v->errors());
        }
        else{
            $manufacturer = new Manufacturer();
            $manufacturer->title = $request->input('title');
            $manufacturer->year_foundation = $request->input('year_foundation');
            $manufacturer->year_termination = $request->input('year_termination');
            $manufacturer->save();

            for ($i = 1; $i < 4; $i++){
                if($request->input('description_'.$i) != null){
                    $lang = new ManufacturerLanguage();
                    $lang->language = $i;
                    $lang->description = $request->input('description_'.$i);
                    $lang->manufacturer()->associate($manufacturer);
                    $lang->save();
                }
            }
            return redirect()->route('manufacturers.index')->with('success','Manufacturer is created.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Manufacturer  $manufacturer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Manufacturer $manufacturer)
    {
        return redirect()->route('manufacturers.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Manufacturer  $manufacturer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Manufacturer $manufacturer)
    {
        $manufacturerArr = [
            1 => ['description' => ''],
            2 => ['description' => ''],
            3 => ['description' => ''],
        ];
        $manufacturerLang = ManufacturerLanguage::all()->where('manufacturer_id',$manufacturer->id);
        for ($i = 1; $i < 4; $i++){
            if ($manufacturerLang->where('language',$i)->first() != null){
                $manufacturerArr[$i]['description'] = $manufacturerLang ->where('language',$i)->first()->description;
            }
        }
        return view('admin.Manufacturer.edit', compact(['manufacturer','manufacturerArr']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Manufacturer  $manufacturer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Manufacturer $manufacturer)
    {
        $v = Validator::make($request->all(), [
            'title' => 'required|min:1|max:256',
            'year_foundation' => 'nullable|integer|max:32000',
            'year_termination' => 'nullable|integer|max:32000',
            'description_1' => 'nullable|max:65535',
            'description_2' => 'nullable|max:65535',
            'description_3' => 'nullable|max:65535',
        ]);
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }
        else {
            $manufacturer->title = $request->input('title');
            $manufacturer->year_foundation = $request->input('year_foundation');
            $manufacturer->year_termination = $request->input('year_termination');
            $manufacturer->save();

            $manufacturerLang = ManufacturerLanguage::all()->where('manufacturer_id', $manufacturer->id);
            for ($i = 1; $i < 4; $i++) {
                if ($manufacturerLang->where('language', $i)->first() != null) {
                    $manufacturerLang->where('language', $i)->first()->description = $request->input('description_' . $i);
                    $manufacturerLang->where('language', $i)->first()->save();
                } else {
                    $lang = new ManufacturerLanguage();
                    $lang->language = $i;
                    $lang->description = $request->input('description_' . $i);
                    $lang->manufacturer()->associate($manufacturer);
                    $lang->save();
                }
            }
            return redirect()->route('manufacturers.index')->with('success', 'Manufacturer is updated.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Manufacturer  $manufacturer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Manufacturer $manufacturer)
    {
        $manufacturerLanguages = ManufacturerLanguage::all()->where('manufacturer_id',$manufacturer->id);
        foreach ($manufacturerLanguages as $lang){
            $lang->delete();
        }
        $manufacturer->delete();
        return redirect()->route('manufacturers.index')->with('success','Manufacturer is deleted.');
    }
}
