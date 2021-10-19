{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title')
    Create Class
@endsection

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/flag-icon/css/flag-icon.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/noUiSlider/nouislider.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/select2/select2-materialize.css') }}">
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/form-select2.css') }}">
@endsection

{{-- page content --}}
@section('content')


    <div class="section">
        <div class="card">
            <div class="card-content">
                <p class="caption mb-0">
                <h6>Create Topic</h6>
                <form class="row" method="POST" action="{{ route('topics-store') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12 m6">
                                <input id="topic" type="text" name="topicName" class="validate" required>
                                <label for="code">Topic Name</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <select name="status" id="status" class="select2 browser-default">
                                    <option value="" disabled selected>Select Status</option>
                                    @foreach (json_decode($responseStatus) as $status)
                                        <option value="{{ $status->id }}">{{ $status->status }}</option>
                                    @endforeach
                                </select>
                                {{-- <label>Status</label> --}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12">
                                <select name="classList" id="classList" class="select2 browser-default">
                                    <option value="" disabled selected>Select Class</option>
                                    @foreach (json_decode($responseClasses) as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12">
                                <select name="module" id="module" class="select2 browser-default">
                                    <option value="">Select a Module for this topic</option>
                                </select>
                            </div>
                        </div>

                        {{-- <option value="" disabled selected>Select a Module for this topic</option> --}}
                        {{-- @foreach (json_decode($responseModules) as $module)
                            <option value="{{ $module->id }}">{{ $module->moduleName }}</option>
                        @endforeach --}}
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12">
                                <button class="btn border-round col s12">Create Topic</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

    <script type="text/javascript">
        jQuery(document).ready(function() {
            // $('select').material_select();
            jQuery('select[name="classList"]').on('change', function() {
                // console.log("Ready");
                var classID = jQuery(this).val();
                // console.log("Class ID - " + classID);
                if (classID) {
                    jQuery.ajax({
                        url: 'moduleclass/' +classID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            // console.log(data);
                            // console.log(data[0].id);
                            // console.log(data[0].moduleName);
                            jQuery('select[name="module"]').empty();
                            jQuery.each(data, function(id, moduleName) {
                            // console.log("Data Id - " + data[id].id);
                            // console.log("Data Module - "+ data[id].moduleName);

                                $("#module").append('<option value="' + data[id].id + '">' + data[id].moduleName +'</option>');
                                $("#module").formSelect();
                            });
                        }
                    });
                } else {
                    $('select[name="module"]').empty();
                }
            });
        });
    </script>
    

@endsection




{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{ asset('vendors/select2/select2.full.min.js') }}"></script>
@endsection

{{-- page script --}}
@section('page-script')
    <script src="{{ asset('js/scripts/form-select2.js') }}"></script>
@endsection
