@extends('layouts.admin')
@section('head-content')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/amsify.suggestags.css') }}">
    <script type="text/javascript" src="{{ asset('js/jquery.amsify.suggestags.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script> var old_img = {{$drugImagesSize}}</script>
    <script> var diseaseArr =  @json($diseaseArr); @if($drug->drug_titles->first() != null) var i = {{sizeof($drug->drug_titles)}}; @else var i = 1 @endif </script>
    <script type="text/javascript" src="{{ asset('js/drug.edit.js') }}"></script>
@endsection
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2>Edit Drug</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('drugs.update',$drug->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <div id="drug_titles">
                                        <label>Drug Titles</label>
                                        @if($drug->drug_titles->first() != null)
                                        @foreach($drug->drug_titles as $i => $title)
                                        <div class="form-group" data-id="{{$title->id}}"  id="drug_title_{{$i+1}}">
                                        <div class="row mb-2">
                                        <div class="col">
                                        <input type="text" value="{{$title->title}}" class="form-control" name="drug_title_text_{{$i+1}}" maxlength="255" required placeholder="Title" />
                                        </div>
                                        <div class="col-2">
                                        <input type="number" value="{{$title->weight}}"  min="1" max="255" class="form-control" required name="drug_title_weight_{{$i+1}}" placeholder="Weight" />
                                        </div>
                                        <div class="col-2">
                                        <select class="form-control"  name="drug_title_language_{{$i+1}}">
                                            <option @if(1 == $title->language) selected="selected" @endif value="1"> English</option>
                                            <option @if(2 == $title->language) selected="selected" @endif value="2"> Russian</option>
                                            <option @if(3 == $title->language) selected="selected" @endif value="3"> Kazakh</option>
                                        </select>
                                        </div>
                                        <input type="hidden" name="drug_title_id_{{$i+1}}" value="{{$title->id}}">
                                        </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <div class="form-group"  id="drug_title_1">
                                            <div class="row">
                                                <div class="col">
                                                    <input type="text" class="form-control" name="drug_title_text_1" maxlength="255" required placeholder="Title" />
                                                </div>
                                                <div class="col-2">
                                                    <input type="number"  min="1" max="255" class="form-control" required name="drug_title_weight_1" placeholder="Weight" />
                                                </div>
                                                <div class="col-2">
                                                    <select class="form-control"  name="drug_title_language_1">
                                                        <option value="1"> English</option>
                                                        <option value="2"> Russian</option>
                                                        <option value="3"> Kazakh</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                </div>
                                <button type="button" class="btn btn-primary" id="add_title" onclick="add_field()">Add title</button>
                                <button type="button" class="btn btn-danger d-none" id="remove_title" onclick="remove_field()">Remove title</button>
                                <input type="hidden" name="drug_titles_count" id="drug_titles_count"  @if(sizeof($drug->drug_titles)>0) value="{{sizeof($drug->drug_titles)}}" @else value="1" @endif />
                            </div>

                            <div class="form-group">
                                <label for="drug_category">Drug Category</label>
                                <select class="form-control selectpicker"  name="drug_category" id="drug_category">
                                    @foreach($drugCategories as $drugCat)
                                        <option value="{{$drugCat->id}}" @if($drug->drug_category_id == $drugCat->id) selected="selected" @endif>
                                            @if($drugCat->drug_category_languages->sortBy('language')->first() == null)
                                                {{$drugCat->id}}
                                            @else
                                                {{$drugCat->drug_category_languages->sortBy('language')->first()->title}}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Disease</label>
                                <select class="form-control"  name="disease_id" id="disease_id"  data-live-search="true">
                                    @foreach($diseaseArr as $disease)
                                        <option value="{{$disease['value']}}" @if($drug->disease_id == $disease['value']) selected="selected" @endif>
                                            {{$disease['tag']}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="drug_id">Drug related to</label>
                                <select class="form-control" name="drug_id" id="drug_id" data-live-search="true">
                                    <option value="">None</option>
                                    @foreach($drugs as $drug_select)
                                    <option value="{{$drug_select->id}}" @if($drug->drug_id == $drug_select->id) selected="selected" @endif>
                                        @if($drug_select->drug_titles()->first() == null)
                                            {{$drug_select->id}}
                                        @else
                                           {{$drug_select->drug_titles->sortBy(['language','weight'])->first()->title}}
                                        @endif
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" @if($drug->child_contradiction) checked @endif type="checkbox" value="1" id="child_contradiction" name="child_contradiction">
                                    <label class="form-check-label" for="child_contradiction">
                                        has child contradiction.
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" @if($drug->pregnancy_contradiction) checked @endif type="checkbox" value="1" id="pregnancy_contradiction" name="pregnancy_contradiction">
                                    <label class="form-check-label" for="pregnancy_contradiction">
                                        has pregnancy contradiction.
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Diseases for contradiction</label>
                                <input type="text" class="form-control" value="{{$diseaseContradiction}}" name="contradiction_diseases" placeholder="List of diseases" />
                            </div>

                            <div class="form-group">
                                <label>Manufacturer</label>

                                <select class="form-control"  name="manufacturer_id" id="manufacturer_id"  data-live-search="true">
                                    <option value="-1" selected="selected">
                                        No manufacturer
                                    </option>

                                    @foreach($manufacturerArr as $man)
                                        <option value="{{$man['value']}}">
                                            {{$man['tag']}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <div id="drug_titles">
                                    <div class="form-group" id="drug_images">
                                        <label>Images</label>
                                        @foreach($drug->drug_images as $i => $image)
                                            @php
                                                $plo = explode('/',$image->image_name)[2];
                                            @endphp
                                            <div class="mb-2" id="old_image_{{$i+1}}"  data-id="{{$image->id}}"> <a class="images" data-src="{{asset('images/'.$plo)}}" href="{{asset('images/'.$plo)}}">{{$plo}}</a> <button type="button" class="btn btn-danger delete_image" >Delete</button> </div>
                                        @endforeach
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary" id="add_image">Add image</button>
                                <button type="button" class="btn btn-danger d-none" id="remove_image">Remove image</button>

                                <input type="hidden" name="old_images_count" id="old_images_count"  value="{{$drugImagesSize}}"/>
                                <input type="hidden" name="drug_images_count" id="drug_images_count"  value="0"/>
                            </div>

                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_1">Add English Translation</button>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_2">Add Russian Translation</button>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_3">Add Kazakh Translation</button>
                            @for($i = 1; $i < 4; $i++)
                                <div class="modal fade" id="modal_{{$i}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    @switch($i)
                                                        @case(1)
                                                        English
                                                        @break
                                                        @case(2)
                                                        Russian
                                                        @break
                                                        @default
                                                        Kazakh
                                                    @endswitch
                                                    translation
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <button type="button" id="toggle-side-effect" class="btn btn-primary mb-2 sbtn{{$i}}">Show side effect</button>
                                                <div class="border border-primary rounded p-2 mb-3" style="display:none" id="side{{$i}}">
                                                    @php
                                                       $sideLang = $drug->side_effect->side_effect_languages->where('language',$i)->first();
                                                    @endphp
                                                    <h3>Side effect</h3>
                                                    <div class="form-group">
                                                        <label class="col-form-label">Description:</label>
                                                        <textarea class="form-control" name="side_description_{{$i}}"  rows="4" cols="50">@if($sideLang != null){{$sideLang->description}}@endif</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label">General:</label>
                                                        <textarea class="form-control" name="side_general_{{$i}}"  rows="4" cols="50">@if($sideLang != null){{$sideLang->general}}@endif</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label">Doctor attention:</label>
                                                        <textarea class="form-control" name="side_doctor_attention_{{$i}}"  rows="4" cols="50">@if($sideLang != null){{$sideLang->doctor_attention}}@endif</textarea>
                                                    </div>
                                                </div>
                                                <br>
                                                <button type="button" id="toggle-contradiction" class="btn btn-primary cbtn{{$i}}">Show contradiction</button>
                                                <div class="border border-info rounded p-2 mb-5 mt-2" style="display:none" id="contradiction{{$i}}">
                                                    <h3>Contradiction</h3>
                                                    @php
                                                        $contradictionLang = $drug->contradiction->contradiction_languages->where('language',$i)->first();
                                                    @endphp
                                                    <div class="form-group">
                                                        <label class="col-form-label">Description:</label>
                                                        <textarea class="form-control" name="contradiction_description_{{$i}}"  rows="4" cols="50">@if($contradictionLang != null){{$contradictionLang->description}}@endif</textarea>
                                                    </div>
                                                </div>
                                                @php
                                                    $drugLang = $drug->drug_languages->where('language',$i)->first();
                                                @endphp
                                                <div class="form-group">
                                                    <label class="col-form-label">Description:</label>
                                                    <textarea class="form-control" name="description_{{$i}}"  rows="4" cols="50">@if($drugLang != null){{$drugLang->description}}@endif</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Composition:</label>
                                                    <textarea class="form-control" name="composition_{{$i}}"  rows="4" cols="50">@if($drugLang != null){{$drugLang->composition}}@endif</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Dosage:</label>
                                                    <textarea class="form-control" name="dosage_{{$i}}"  rows="2" cols="50">@if($drugLang != null){{$drugLang->dosage}}@endif</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Availability:</label>
                                                    <textarea class="form-control" name="availability_{{$i}}"  rows="2" cols="50">@if($drugLang != null){{$drugLang->availability}}@endif</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Special instructions:</label>
                                                    <textarea class="form-control" name="special_instructions_{{$i}}"  rows="2" cols="50">@if($drugLang != null){{$drugLang->special_instructions}}@endif</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Drug interaction:</label>
                                                    <textarea class="form-control" name="drug_interaction_{{$i}}"  rows="2" cols="50">@if($drugLang != null){{$drugLang->drug_interaction}}@endif</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-outline-primary btn-lg">Create</button>
                            </div>
                        </form>
                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function add_field(){
            i++;
            var x = $("#drug_titles");
            var new_field = ' <div class="form-group" id="drug_title_'+i+'">' +
                '<div class="row">' +
                '<div class="col">' +
                '<input type="text" class="form-control" maxlength="255" required  name="drug_title_text_'+i+'" placeholder="Title" />' +
                '</div> ' +
                '<div class="col-2">'+
                '<input type="number" min="1"  max="255" required class="form-control" name="drug_title_weight_'+i+'" placeholder="Weight" />'+
                '</div> ' +
                '<div class="col-2">'+
                '<select class="form-control"  name="drug_title_language_'+i+'">'+
                '<option value="1"> English</option> <option value="2"> Russian</option> <option value="3"> Kazakh</option>'+
                '</select>'+
                '</div> ' +
                '</div> ' +
                '</div>';
            x.append(new_field);
            $("#drug_titles_count").val(i);
            if(i > 1){
                $("#remove_title").removeClass('d-none');
            }
        }
        function remove_field(){
            if (i !== 1) {
                let id = $("#drug_title_"+i).data("id");
                if (id !== undefined){
                    var token = $("meta[name='csrf-token']").attr("content");
                    $.ajax(
                        {
                            url: '/admin/drugs/drug_title/'+id,
                            type: 'GET',
                            data: {
                                "id": id,
                                "_token": token,
                            },
                            success: function (){
                                console.log("it Works");
                            }
                        });
                }

                $("#drug_title_"+i).remove();

                i--;
                $("#drug_titles_count").val(i);
                if (i === 1){
                    $("#remove_title").addClass('d-none');
                }
            }
        }
    </script>
@endsection

