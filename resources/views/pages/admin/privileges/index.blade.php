{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Privileges List')

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
                                <a class="waves-effect waves-light btn modal-trigger mb-2 mr-1" href="#new-user">
                                    <i class="material-icons left">add_circle_outline</i>
                                    Create New Privilege
                                </a>
                            </div>
                        </div>
                        <h4 class="card-title">Page Length Options</h4>
                        <div class="row">
                            <div class="col s12">
                                <table id="page-length-option" class="display">
                                    <thead>
                                        <tr>
                                            <th>Privilege Code</th>
                                            <th>Privilege Title</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (json_decode($response) as $privilege)
                                            <tr>
                                                <td>{{ $privilege->id }}</td>
                                                <td>{{ $privilege->title }}</td>
                                                <td>
                                                    <a href="#e{{ $privilege->id }}" class=" modal-trigger mr-5">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    {{-- <a href="{{ route('users-view', ['id' => $privilege->id]) }}"
                                                        class="mr-5">
                                                        <i class="material-icons">remove_red_eye</i>
                                                    </a> --}}
                                                    <a href="#{{ $privilege->id }}" class=" modal-trigger mr-5">
                                                        <i class="material-icons">delete</i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col s12">
                                                            <div id="e{{ $privilege->id }}" class="modal">
                                                                <div class="modal-content">
                                                                    <h6>Update User</h6>
                                                                    <form class="row" method="POST"
                                                                        action="{{ route('privileges-update', ['id' => $privilege->id]) }}">
                                                                        @csrf
                                                                        {{ method_field('PATCH') }}
                                                                        <div class="col s12">
                                                                            <div class="input-field col s12">
                                                                                <input id="title" type="text" name="title"
                                                                                    class="validate" required value="{{ $privilege->title }}">
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
                                                    </div>
                                                    <div class="row">
                                                        <div class="col s12">
                                                            <div id="{{ $privilege->id }}" class="modal">
                                                                <div class="modal-content">
                                                                    <h6>Delete Privilege</h6>
                                                                    <p>Are you sure you want to delete
                                                                        <b>{{ $privilege->id }}</b> from the privileges list?</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <a href="#"
                                                                        class="modal-action modal-close waves-effect waves-red btn-flat ">No,
                                                                        Cancel</a>
                                                                    <a href="{{ route('privileges-delete', ['id' => $privilege->id]) }}"
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
                                            <th>Privilege Code</th>
                                            <th>Privilege Title</th>
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



    <div id="new-user" class="modal">
        <div class="modal-content">
            <h6>Create a New Privilge</h6>
            <form class="row" method="POST" action="{{ route('privileges-store') }}">
                {{ csrf_field() }}
                <div class="col s12">
                    <div class="input-field col s6">
                        <input id="code" type="text" name="code" class="validate" required size="3" maxlength="3"
                            style="text-transform:uppercase">
                        <label for="code">Privilege Code</label>
                    </div>
                    <div class="input-field col s6">
                        <input id="title" type="text" name="title" class="validate" required>
                        <label for="title">Privilege Title</label>
                    </div>
                </div>

                <div class="col s12">
                    <div class="input-field col s12">
                        <button class="btn border-round col s12">Create Privilege</button>
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
@endsection
