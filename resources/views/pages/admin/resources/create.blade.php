{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title')
    Upload Resources
@endsection

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/flag-icon/css/flag-icon.min.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('vendors/noUiSlider/nouislider.min.css') }}"> --}}

    {{-- Select 2 --}}
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
    {{-- <p>I think Quill Rich Editor is <span class="ql-size-large" style="background-color: rgb(255, 255, 0);">working
            now</span></p>
    <p><br></p>
    <p><img
            src="data:image/png;base64,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">
    </p> --}}

    <div class="section">
        <div class="card">
            <div class="card-content">
                <p class="caption mb-0">
                <h6>Upload Class Resources</h6>
                <form class="row mt-1" id="myForm" method="POST" action="{{ route('resources-store') }}"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12">
                                <input id="title" type="text" name="resourceTitle" class="validate" required>
                                <label for="title">Resource Title</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12">
                                <h>Class</h>
                                <select name="class" id="class" class="select2 browser-default">
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
                                <h>Resource Type</h>
                                <select name="resourceType" id="resource" class="select2 browser-default">
                                    <option value="" disabled selected>Select a Reource Type</option>
                                    @foreach (json_decode($responseResTypes) as $resType)
                                        <option value="{{ $resType->id }}">{{ $resType->type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12">
                                <h>Status</h>
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

                    <div class="divider mb-1 mt-1"></div>
                    <div class="row section">
                        <div class="col s12">
                            <p>Upload Resource</p>
                        </div>
                        <div class="col s12">
                            <span class="helper-text" style="color: red">Maximum file upload size 2MB.</span>
                            <input name="imagePath" type="file" id="input-file-max-fs" class="dropify"
                                data-max-file-size="2M" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12">
                                <button class="btn border-round col s12">Upload</button>
                            </div>
                        </div>
                    </div>
                </form>
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
