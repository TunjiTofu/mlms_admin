{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Quizzes')

{{-- vendors styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/select.dataTables.min.css') }}">
@endsection

{{-- page styles --}}
@section('page-style')
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/page-users.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/data-tables.css') }}">
@endsection

{{-- page content --}}
@section('content')
    {{-- Data Table Starts Here --}}
    <div class="section section-data-tables">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12 m6 l3">
                                <a class="waves-effect waves-light btn modal-trigger mb-2 mr-1" href="#new-quiz">
                                    <i class="material-icons left">add_circle_outline</i>
                                    Create New Quiz
                                </a>
                            </div>
                        </div>
                        <h4 class="card-title">Quiz Details</h4>
                        <div class="row">
                            <div class="col s12">
                                <table id="page-length-option" class="display">
                                    <thead>
                                        <tr>
                                            <th>Quiz Title</th>
                                            <th>NoQ</th>
                                            <th>Duration (Mins)</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (json_decode($response) as $quiz)
                                            <tr>
                                                <td>
                                                    <b>{{ $quiz->title }}</b><br>
                                                    @php
                                                        $id_token = session()->get('id_Token');
                                                        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses/' . $quiz->class);
                                                        $className = json_decode($response);
                                                        // dd($className)
                                                    @endphp
                                                    <b>Class: </b> <br>{{ ucwords($className->name) }}
                                                </td>
                                                <td>
                                                    {{ $quiz->noq }}
                                                </td>
                                                <td>
                                                    {{ $quiz->duration }}
                                                </td>
                                                <td>
                                                    @if ($quiz->status == 'active')
                                                        <span class="chip green lighten-5">
                                                            <span class="green-text">Active</span>
                                                        </span>
                                                    @endif
                                                    @if ($quiz->status == 'disabled')
                                                        <span class="chip red lighten-5">
                                                            <span class="red-text">Disabled</span>
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <b>Created on: </b>
                                                    @php
                                                        if (!empty($quiz->createdAt->_seconds)) {
                                                            $timestamp = $quiz->createdAt->_seconds;
                                                            date_default_timezone_set('Africa/Lagos');
                                                            echo date('d-M-Y h:i a', $timestamp);
                                                        }
                                                    @endphp
                                                    <br>
                                                    <b>Last Updated on: </b>
                                                    @php
                                                        if (!empty($quiz->updatedAt->_seconds)) {
                                                            $timestamp2 = $quiz->updatedAt->_seconds;
                                                            date_default_timezone_set('Africa/Lagos');
                                                            echo date('d-M-Y h:i a', $timestamp2);
                                                        } else {
                                                            echo '-';
                                                        }
                                                        
                                                    @endphp
                                                </td>
                                                <td>
                                                    <a href="{{ route('quizzes-view', ['quizId' => $quiz->id,'classId' => $quiz->class], ) }}"
                                                        class="mr-5" title="Add Questions to this Quiz">
                                                        <i class="material-icons">add_circle_outline</i>
                                                    </a>
                                                    
                                                    <a href="#e{{ $quiz->id }}" class=" modal-trigger mr-5" title="Edit Selected Quiz Details">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                   
                                                    <a href="#{{ $quiz->id }}" class=" modal-trigger mr-5" title="Delete Selected Quiz">
                                                        <i class="material-icons">delete</i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col s12">
                                                            <div id="e{{ $quiz->id }}" class="modal">
                                                                <div class="modal-content">
                                                                    <h6>Update Quiz Details</h6>
                                                                    <form class="row" method="POST"
                                                                        action="{{ route('quizzes-update', ['id' => $quiz->id]) }}">
                                                                        @csrf
                                                                        {{ method_field('PATCH') }}
                                                                        <div class="col s12">
                                                                            <div class="input-field col s12 m6">
                                                                                <input id="title" type="text" name="title"
                                                                                    class="validate" required
                                                                                    value="{{ $quiz->title }}">
                                                                                <label for="title">Quiz Title</label>
                                                                            </div>
                                                                            <div class="input-field col s12 m6">
                                                                                <select name="class"
                                                                                    class="select2 browser-default">
                                                                                    <option value="0" disabled selected>
                                                                                        Select Class</option>
                                                                                    @foreach (json_decode($responseClasses) as $classes)
                                                                                        <option
                                                                                            value="{{ $classes->id }}"
                                                                                            {{ $classes->id == $quiz->class ? 'selected = "selected"' : '' }}>
                                                                                            {{ strtoupper($classes->name) }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col s12">
                                                                            <div class="input-field col s12 m4">
                                                                                <input id="noq" type="number" name="noq"
                                                                                    class="validate" required
                                                                                    value="{{ $quiz->noq }}">
                                                                                <label for="noq">Number of Questions</label>
                                                                                <span class="helper-text"
                                                                                    style="color: red">Number of Questions
                                                                                    to Be <br>Answered By Each
                                                                                    Student</span>
                                                                            </div>
                                                                            <div class="input-field col s12 m4">
                                                                                <input id="duration" type="number"
                                                                                    name="duration" class="validate"
                                                                                    value="{{ $quiz->duration }}"
                                                                                    required>
                                                                                <label for="duration">Duration in
                                                                                    Minutes</label>
                                                                                <span class="helper-text"
                                                                                    style="color: red">(in Minutes)</span>
                                                                            </div>
                                                                            <div class="input-field col s12 m4">
                                                                                <select name="status"
                                                                                    class="select2 browser-default">
                                                                                    <option value="0" disabled selected>
                                                                                        Select Status</option>
                                                                                    @foreach (json_decode($responseStatus) as $status)
                                                                                        <option value="{{ $status->id }}"
                                                                                            {{ $status->id == $quiz->status ? 'selected = "selected"' : '' }}>
                                                                                            {{ $status->status }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col s12">
                                                                            <div class="input-field col s12">
                                                                                <button
                                                                                    class="btn border-round col s12">Update
                                                                                    Quiz Details</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col s12">
                                                            <div id="{{ $quiz->id }}" class="modal">
                                                                <div class="modal-content">
                                                                    <h6>Delete Quiz Details</h6>
                                                                    <p>Are you sure you want to delete
                                                                        <b>{{ $quiz->title }}</b> from the list?
                                                                    </p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <a href="#"
                                                                        class="modal-action modal-close waves-effect waves-red btn-flat ">No,
                                                                        Cancel</a>
                                                                    <a href="{{ route('quizzes-delete', ['id' => $quiz->id]) }}"
                                                                        class="modal-action modal-close waves-effect waves-green btn-flat ">Yes,
                                                                        Delete</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </td>
                                                {{-- <td><a href="{{ route('users-view',['id'=>$hashid->encode($user->id)])) }}"><i --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Quiz Title</th>
                                            <th>NoQ</th>
                                            <th>Duration (Mins)</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Data Table Ends Here --}}



    <div id="new-quiz" class="modal">
        <div class="modal-content">
            <h6>Create a New Quiz</h6>
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
                        <input id="noq" type="number" name="noq" class="validate" required>
                        <label for="noq">Number of Questions</label>
                        <span class="helper-text" style="color: red">Number of Questions to Be Answered By Each
                            Student</span>
                    </div>
                    <div class="input-field col s12 m4">
                        <input id="duration" type="number" name="duration" class="validate" required>
                        <label for="duration">Duration in Minutes</label>
                        <span class="helper-text" style="color: red">(in Minutes)</span>
                    </div>
                    <div class="input-field col s12 m4">
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
                        <button class="btn border-round col s12">Create Class</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{ asset('vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendors/data-tables/js/dataTables.select.min.js') }}"></script>
@endsection

{{-- page script --}}
@section('page-script')
    <script src="{{ asset('js/scripts/data-tables.js') }}"></script>
    <script src="{{ asset('js/scripts/advance-ui-modals.js') }}"></script>
    <script src="{{ asset('js/scripts/ui-alerts.js') }}"></script>
@endsection
