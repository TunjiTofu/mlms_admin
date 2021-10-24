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
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/dropify/css/dropify.min.css') }}">
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
                <h5>Create New Class</h5>
                </p>

                <div id="view-input-fields">
                    <div class="row">
                        <div class="col s12">
                            <form class="row" method="POST" action="{{ route('classes-store') }}">
                                {{ csrf_field() }}
                                <div class="col s12">
                                    <div class="input-field col s12 m6">
                                        <input id="name" type="text" name="name" class="validate" required>
                                        <label for="name">Name Your Class</label>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <select name="teacher" class="select2 browser-default">
                                            <option value="0" disabled selected>Select Teacher</option>
                                            @foreach (json_decode($response) as $teacher)
                                                <option value="{{ $teacher->id }}">{{ strtoupper($teacher->sname) }},
                                                    {{ ucwords($teacher->oname) }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="col s12">
                                    <div class="input-field col s12">
                                        <textarea id="message5" class="materialize-textarea" maxlength="250"
                                            name="description"></textarea>
                                        <label for="message">Class Description</label>
                                    </div>
                                </div>
                                <div class="col s12">
                                    <div class="input-field col s12 m6">
                                        <select name="status">
                                            <option value="" disabled selected>Select Status</option>
                                            @foreach (json_decode($responseStatus) as $status)
                                                <option value="{{ $status->id }}">{{ $status->status }}</option>
                                            @endforeach
                                        </select>
                                        <label>Status</label>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <span><input id="color" type="color" name="color" class="validate"
                                                value="#1976D2" required></span>
                                        <span><label for="color">Choose a Class Color</label></span>
                                    </div>
                                </div>

                                <div class="divider mb-1 mt-1"></div>
                                <div class="row section">
                                    <div class="col s12">
                                        <p>Upload Class Image</p>
                                    </div>
                                    <div class="col s12">
                                        <span class="helper-text" style="color: red">Maximum file upload size 2MB.</span>
                                        <input name="imagePath" type="file" id="input-file-max-fs" class="dropify"
                                            data-max-file-size="2M" />
                                    </div>
                                </div>

                                <div class="col s12">
                                    <div class="input-field col s12">
                                        <button class="btn border-round col s12">Create Class</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection


{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{ asset('vendors/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('vendors/dropify/js/dropify.min.js') }}"></script>
@endsection

{{-- page script --}}
@section('page-script')
    <script src="{{ asset('js/scripts/form-select2.js') }}"></script>
    <script src="{{ asset('js/scripts/form-file-uploads.js') }}"></script>
@endsection
