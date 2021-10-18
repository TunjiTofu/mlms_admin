{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Classes List')

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
                                <a class="waves-effect waves-light btn modal-trigger mb-2 mr-1" href="#new-class">
                                    <i class="material-icons left">add_circle_outline</i>
                                    Create New Class
                                </a>
                            </div>
                        </div>
                        <h4 class="card-title">All Privileges</h4>
                        <div class="row">
                            <div class="col s12">
                                <table id="page-length-option" class="display">
                                    <thead>
                                        <tr>
                                            <th>Class Name</th>
                                            <th>Teacher</th>
                                            <th>Status</th>
                                            <th>Date Created</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (json_decode($response) as $class)
                                            <tr>
                                                <td>
                                                    {{ $class->name }}<br>
                                                    <b>Class Code: </b> {{ $class->classCode }}
                                                </td>
                                                <td>
                                                    @php
                                                        $id_token = session()->get('id_Token');
                                                        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/users/' . $class->teacher);
                                                        $teacher = json_decode($response);
                                                        // dd($teacher)
                                                    @endphp
                                                    {{ strtoupper($teacher->sname) }}, {{ ucwords($teacher->oname) }}
                                                </td>
                                                <td>
                                                    @if ($class->status == 'active')
                                                        <span class="chip green lighten-5">
                                                            <span class="green-text">Active</span>
                                                        </span>
                                                    @endif
                                                    @if ($class->status == 'disabled')
                                                        <span class="chip red lighten-5">
                                                            <span class="red-text">Disabled</span>
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <b>Created on: </b>
                                                    @php
                                                        $timestamp = $class->createdAt->_seconds;
                                                        date_default_timezone_set("Africa/Lagos");
                                                        echo date('d-M-Y h:i a',$timestamp);
                                                    @endphp
                                                    <br>
                                                    <b>Last Updated on: </b>
                                                    @php
                                                        $timestamp2 = $class->updatedAt->_seconds;
                                                        date_default_timezone_set("Africa/Lagos");
                                                        echo date('d-M-Y h:i a',$timestamp2);
                                                    @endphp
                                                </td>
                                                <td>
                                                    <a href="{{ route('classes-edit', ['id' => $class->id]) }}" class=" modal-trigger mr-5">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <a href="{{ route('classes-view', ['id' => $class->id]) }}"
                                                        class="mr-5">
                                                        <i class="material-icons">remove_red_eye</i>
                                                    </a>
                                                    <a href="#{{ $class->id }}" class=" modal-trigger mr-5">
                                                        <i class="material-icons">delete</i>
                                                    </a>
                                                </td>
                                                <td>
                                                    {{-- <div class="row">
                                                        <div class="col s12">
                                                            <div id="e{{ $class->id }}" class="modal">
                                                                <div class="modal-content">
                                                                    <h6>Update User</h6>
                                                                    <form class="row" method="POST"
                                                                        action="{{ route('privileges-update', ['id' => $class->id]) }}">
                                                                        @csrf
                                                                        {{ method_field('PATCH') }}
                                                                        <div class="col s12">
                                                                            <div class="input-field col s12">
                                                                                <input id="title" type="text" name="title"
                                                                                    class="validate" required
                                                                                    value="{{ '$privilege->title' }}">
                                                                                <label for="title">Privilege Title</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col s12">
                                                                            <div class="input-field col s12">
                                                                                <button
                                                                                    class="btn border-round col s12">Update
                                                                                    Privilege</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    <div class="row">
                                                        <div class="col s12">
                                                            <div id="{{ $class->id }}" class="modal">
                                                                <div class="modal-content">
                                                                    <h6>Delete Privilege</h6>
                                                                    <p>Are you sure you want to delete
                                                                        <b>{{ $class->name }}</b> from the class list?
                                                                    </p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <a href="#"
                                                                        class="modal-action modal-close waves-effect waves-red btn-flat ">No,
                                                                        Cancel</a>
                                                                    <a href="{{ route('classes-delete', ['id' => $class->id]) }}"
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
                                            <th>Class Name</th>
                                            <th>Teacher</th>
                                            <th>Status</th>
                                            <th>Date Created</th>
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



    <div id="new-class" class="modal">
        <div class="modal-content">
            <h6>Create a New Class</h6>
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
                            @foreach (json_decode($responseTeachers) as $teacher)
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
