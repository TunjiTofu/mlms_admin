{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title')
    Create Quiz Details
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
                <h5>Create Quiz Details</h5>
                </p>

                <div id="view-input-fields">
                    <div class="row">
                        <div class="col s12">
                            <form class="row" method="POST" action="{{ route('quizzes-store') }}">
                                {{ csrf_field() }}
                                <div class="col s12">
                                    <div class="input-field col s12 m6">
                                        <input id="title" type="text" name="title" class="validate" required>
                                        <label for="title">Quiz Title</label>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <select name="class" class="select2 browser-default">
                                            <option value="0" disabled selected>Select Class</option>
                                            @foreach (json_decode($responseClasses) as $classes)
                                                <option value="{{ $classes->id }}">{{ strtoupper($classes->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="col s12">
                                    <div class="input-field col s12 m4">
                                        <input id="noq" type="number" name="noqScq" class="validate" required>
                                        <label for="noq">Number of OBJ Questions</label>
                                        <span class="helper-text" style="color: red">Number of Objective Questions to Be Answered
                                            By Each Student</span>
                                    </div>
                                    <div class="input-field col s12 m4">
                                        <input id="noq" type="number" name="noqBq" class="validate" required>
                                        <label for="noq">Number of Binary Questions</label>
                                        <span class="helper-text" style="color: red">Number of True/False Questions to Be Answered
                                            By Each Student</span>
                                    </div>
                                    <div class="input-field col s12 m4">
                                        <input id="noq" type="number" name="noqTheory" class="validate" required>
                                        <label for="noq">Number of Theory Questions</label>
                                        <span class="helper-text" style="color: red">Number of Theory Questions to Be Answered
                                            By Each Student</span>
                                    </div>
                                </div>

                                <div class="col s12">
                                    <div class="input-field col s12 m6">
                                        <input id="duration" type="number" name="duration" class="validate" required>
                                        <label for="duration">Duration in Minutes</label>
                                        <span class="helper-text" style="color: red">(in Minutes)</span>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <select name="status" class="select2 browser-default">
                                            <option value="0" disabled selected>Select Status</option>
                                            @foreach (json_decode($responseStatus) as $status)
                                                <option value="{{ $status->id }}">{{ $status->status }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="col s12">
                                    <div class="input-field col s12">
                                        <button class="btn border-round col s12">Create Quiz</button>
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
