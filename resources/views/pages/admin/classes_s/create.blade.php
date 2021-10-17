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
                                        <select name="teacher">
                                            <option value="0" disabled selected>Select Teacher</option>
                                            @foreach (json_decode($response) as $teacher)
                                                <option value="{{ $teacher->id }}">{{ strtoupper($teacher->sname) }}, {{ ucwords($teacher->oname) }}</option>
                                            @endforeach
                                        </select>
                                        <label>Select Class Teacher</label>
                                    </div>
                                </div>
                                <div class="col s12">
                                    <div class="input-field col s12">
                                        <textarea id="message5" class="materialize-textarea" maxlength="250" name="description"></textarea>
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
                                        <span><input id="color" type="color" name="color" class="validate" value="#1976D2" required></span>
                                        <span><label for="color">Choose a Class Color</label></span>
                                    </div>
                                </div>

                                <div class="col s12">
                                    <div class="col s12 file-field input-field">
                                        <div class="btn float-right">
                                            <span>Click to Attach Image</span>
                                            <input type="file">
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input class="file-path validate" type="text" name="imagePath">
                                        </div>
                                        <span class="helper-text" style="color: red">Supported file types: .png, .jpg, .jpeg</span>
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
