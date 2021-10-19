{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Topics List')

{{-- vendors styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/select.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/select2/select2-materialize.css') }}">
@endsection

{{-- page styles --}}
@section('page-style')
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/page-users.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/data-tables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/form-select2.css') }}">
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
                                <a class="waves-effect waves-light btn modal-trigger mb-2 mr-1" href="{{ route('topics-add') }}">
                                    {{-- <a class="waves-effect waves-light btn modal-trigger mb-2 mr-1" href="#new-user"> --}}
                                   
                                    <i class="material-icons left">add_circle_outline</i>
                                    Create New Topic
                                </a>
                            </div>
                        </div>
                        <h4 class="card-title">All Topics</h4>
                        <div class="row">
                            <div class="col s12">
                                <table id="page-length-option" class="display">
                                    <thead>
                                        <tr>
                                            <th>Topic</th>
                                            <th>Class Name</th>
                                            <th>Module</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (json_decode($response) as $topic)
                                        <tr>
                                            <td>{{ $topic->topicName }}</td>
                                            <td>
                                                {{-- {{ $topic->class }} --}}
                                                @php
                                                        $id_token = session()->get('id_Token');
                                                        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses/' . $topic->class);
                                                        $class = json_decode($response);
                                                        // dd($teacher)
                                                    @endphp
                                                    {{ $class->name }}
                                            </td>
                                            <td>
                                                {{-- {{ $topic->module }} --}}
                                                @php
                                                        $id_token = session()->get('id_Token');
                                                        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminModules/' .$topic->module);
                                                        $module = json_decode($response);
                                                        // dd($teacher)
                                                    @endphp
                                                    {{ $module->moduleName }}
                                            </td>
                                            <td>
                                                @if ($topic->status == 'active')
                                                    <span class="chip green lighten-5">
                                                        <span class="green-text">Active</span>
                                                    </span>
                                                @endif
                                                @if ($topic->status == 'disabled')
                                                    <span class="chip red lighten-5">
                                                        <span class="red-text">Disabled</span>
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <b>Created on: </b>
                                                @php
                                                        $timestamp = $topic->createdAt->_seconds;
                                                        date_default_timezone_set('Africa/Lagos');
                                                        echo date('d-M-Y h:i a', $timestamp);
                                                    @endphp
                                                    <br>
                                                    <b>Last Updated on: </b>
                                                    @php
                                                        if ($topic->updatedAt != "") {
                                                            $timestamp2 = $topic->updatedAt->_seconds;
                                                            date_default_timezone_set('Africa/Lagos');
                                                            echo date('d-M-Y h:i a', $timestamp2);
                                                        }
                                                        
                                                    @endphp
                                            </td>
                                            <td>
                                                <a href="{{ route('topics-edit', ['id' => $topic->id]) }}" class=" modal-trigger mr-5">
                                                    {{-- <a href="#e{{ $topic->id }}" class=" modal-trigger mr-5"> --}}
                                                    <i class="material-icons">edit</i>
                                                </a>
                                                {{-- <a href="{{ route('users-view', ['id' => $topic->id]) }}"
                                                        class="mr-5">
                                                        <i class="material-icons">remove_red_eye</i>
                                                    </a> --}}
                                                <a href="#{{ $topic->id }}" class=" modal-trigger mr-5">
                                                    <i class="material-icons">delete</i>
                                                </a>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col s12">
                                                        <div id="e{{ $topic->id }}" class="modal">
                                                            <div class="modal-content">
                                                                <h6>Update Module</h6>
                                                                <form class="row" method="POST"
                                                                    action="{{ route('modules-update', ['id' => $topic->id]) }}">
                                                                    @csrf
                                                                    {{ method_field('PATCH') }}
                                                                    <div class="row">
                                                                        <div class="col s12">
                                                                            <div class="input-field col s12 m6">
                                                                                <input id="code" type="text"
                                                                                    name="moduleName" class="validate"
                                                                                    value="{{ '$module->moduleName' }}"
                                                                                    required>
                                                                                <label for="code">Module Name</label>
                                                                            </div>
                                                                            <div class="input-field col s12 m6">
                                                                                <select name="status">
                                                                                    <option value="" disabled selected>
                                                                                        Select Status</option>
                                                                                    {{-- @foreach (json_decode($responseStatus) as $status)
                                                                                            <option value="{{ $status->id }}" 
                                                                                                {{ $status->id == $module->status ? 'selected = "selected"' : '' }}>{{ $status->status }}
                                                                                            </option>
                                                                                        @endforeach --}}
                                                                                </select>
                                                                                <label>Status</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col s12">
                                                                            <div class="input-field col s12">
                                                                                <select name="class">
                                                                                    <option value="" disabled selected>
                                                                                        Select Class</option>
                                                                                    {{-- @foreach (json_decode($responseClasses) as $class)
                                                                                            <option value="{{ $class->id }}"
                                                                                                {{ $class->id == $module->class ? 'selected = "selected"' : '' }}>{{ $class->name }}
                                                                                            </option>
                                                                                        @endforeach --}}
                                                                                </select>
                                                                                <label>Class</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col s12">
                                                                        <div class="input-field col s12">
                                                                            <button class="btn border-round col s12">Update
                                                                                Module</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col s12">
                                                        <div id="{{ $topic->id }}" class="modal">
                                                            <div class="modal-content">
                                                                <h6>Delete Module</h6>
                                                                <p>Are you sure you want to delete
                                                                    <b>{{ $topic->topicName }}</b> from the Topic
                                                                    list?
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="#"
                                                                    class="modal-action modal-close waves-effect waves-red btn-flat ">No,
                                                                    Cancel</a>
                                                                <a href="{{ route('topics-delete', ['id' => $topic->id]) }}"
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
                                            <th>Topic</th>
                                            <th>Class Name</th>
                                            <th>Module</th>
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

@endsection



{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{ asset('vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendors/data-tables/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('vendors/select2/select2.full.min.js') }}"></script>
@endsection

{{-- page script --}}
@section('page-script')
    <script src="{{ asset('js/scripts/data-tables.js') }}"></script>
    <script src="{{ asset('js/scripts/advance-ui-modals.js') }}"></script>
    <script src="{{ asset('js/scripts/ui-alerts.js') }}"></script>
    <script src="{{ asset('js/scripts/form-select2.js') }}"></script>
@endsection
