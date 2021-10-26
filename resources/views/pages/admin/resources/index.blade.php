{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Classes Resources')

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
                                <a class="waves-effect waves-light btn modal-trigger mb-2 mr-1" href="{{ route('resources-add') }}">
                                    <i class="material-icons left">add_circle_outline</i>
                                    Upload New Resources
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
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (json_decode($responseClasses) as $class)
                                            <tr>
                                                <td>
                                                    {{ $class->name }}<br>
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
                                                    {{-- <a href="{{ route('classes-edit', ['id' => $class->id]) }}" class=" modal-trigger mr-5">
                                                        <i class="material-icons">edit</i>
                                                    </a> --}}
                                                    {{-- <a href="{{ route('classes-view', ['id' => $class->id]) }}"
                                                        class="mr-5">
                                                        <i class="material-icons">remove_red_eye</i> View Class Resources
                                                    </a> --}}

                                                    <a href="{{ route('resources-view', ['id' => $class->id]) }}" class="waves-effect waves-light btn modal-trigger mb-2 mr-1">
                                                        <i class="material-icons left">remove_red_eye</i>
                                                        View Class Resources
                                                    </a>

                                                    {{-- <a href="#{{ $class->id }}" class=" modal-trigger mr-5">
                                                        <i class="material-icons">delete</i>
                                                    </a> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Class Name</th>
                                            <th>Status</th>
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
                    
                </div>
                <div class="col s12">
                    <div class="input-field col s12">
                        <textarea id="message5" class="materialize-textarea" maxlength="250" name="description"></textarea>
                        <label for="message">Class Description</label>
                    </div>
                </div>
                <div class="col s12">
                    
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
