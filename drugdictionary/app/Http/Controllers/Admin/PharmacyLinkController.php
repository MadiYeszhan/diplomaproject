<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use App\Models\PharmacyLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PharmacyLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $pharmacy_links = PharmacyLink::all();
        return view('admin.PharmacyLink.index', compact(['pharmacy_links']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $drugs = Drug::all();
        return view('admin.PharmacyLink.create', compact(['drugs']));
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
            'link' => 'required|min:1|max:2000',
            'drug_id' => 'required|integer',
            'pharmacy_number' => 'required|integer',
        ]);

        if ($v->fails()){
            return redirect()->back()->withErrors($v->errors());
        }
        else{
            $pharmacy_link = new PharmacyLink();
            $pharmacy_link->link = $request->input('link');
            $pharmacy_link->drug_id = $request->input('drug_id');
            $pharmacy_link->pharmacy_number = $request->input('pharmacy_number');
            $pharmacy_link->save();

            return redirect()->route('pharmacy_links.index')->with('success','Link is created.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PharmacyLink  $pharmacyLink
     * @return \Illuminate\Http\Response
     */
    public function show(PharmacyLink $pharmacyLink)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PharmacyLink  $pharmacyLink
     * @return \Illuminate\Http\Response
     */
    public function edit(PharmacyLink $pharmacyLink)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PharmacyLink  $pharmacyLink
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PharmacyLink $pharmacyLink)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PharmacyLink  $pharmacyLink
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(PharmacyLink $pharmacyLink)
    {
        $pharmacyLink->delete();
        return redirect()->route('pharmacy_links.index')->with('success','Link is deleted.');
    }
}
