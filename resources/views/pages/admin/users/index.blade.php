{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title')

    Users

@endsection

{{-- vendor styles --}}
@section('vendor-style')
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('vendors/flag-icon/css/flag-icon.min.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
@endsection

{{-- page style --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/page-users.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/data-tables.css') }}"> --}}
@endsection


{{-- page content --}}
@php
$id_token = session()->get('id_Token');
$email = session()->get('user_email');
@endphp
@section('content')
    {{-- <div class="section  section-data-tables">
        {{-- <div class="card">
            <div class="card-content">
                Welcome - {{ $email }}
                <h6>Users List</h6>
                <div class="row">
                    <div class="col s12">
                        <table id="page-length-option" class="display">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach (json_decode($response) as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td> Edit | Delete
                                    {{-- <a href="{{ route('products-edit', ['id' => $user->id]) }}" class="btn btn-info">Edit</a> --}}
    {{-- <a href="" class="btn btn-danger"><i class="fa fa-trash"></i></a> --}}

    {{-- <a href="{{ route('products-delete', ['id' => $user->id]) }}">Delete</a> --
                                </td>
                            </tr>
                        @endforeach --}
                                <tr>
                                    <td>1</td>
                                    <td>Tiger Nixon</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Garrett Winters</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
        </div> --}
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <h4 class="card-title">
                            <h6>Users List</h6>
                        </h4>
                        <div class="row">
                            <div class="col s12">
                                <table id="page-length-option" class="display">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (json_decode($response) as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td> Edit | Delete
                                                    {{-- <a href="{{ route('products-edit', ['id' => $user->id]) }}" class="btn btn-info">Edit</a> --}}
    {{-- <a href="" class="btn btn-danger"><i class="fa fa-trash"></i></a> --}}

    {{-- <a href="{{ route('products-delete', ['id' => $user->id]) }}">Delete</a> --
                                          </td> --}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Actions</th>
                                        </tr>

                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> --}}

    <div class="card">
        <div class="card-content">
            <div class="row">
                <div class="col s12">
                  <h6>Users List</h6>
                </div>
            </div>
        </div>
    </div>


        <section class="users-list-wrapper section">
            <div class="users-list-filter">
                <div class="card-panel">
                    <div class="row">
                        <form>
                            <div class="col s12 m6 l3">
                                <label for="users-list-verified">Verified</label>
                                <div class="input-field">
                                    <select class="form-control" id="users-list-verified">
                                        <option value="">Any</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col s12 m6 l3">
                                <label for="users-list-role">Role</label>
                                <div class="input-field">
                                    <select class="form-control" id="users-list-role">
                                        <option value="">Any</option>
                                        <option value="User">User</option>
                                        <option value="Staff">Staff</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col s12 m6 l3">
                                <label for="users-list-status">Status</label>
                                <div class="input-field">
                                    <select class="form-control" id="users-list-status">
                                        <option value="">Any</option>
                                        <option value="Active">Active</option>
                                        <option value="Close">Close</option>
                                        <option value="Banned">Banned</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col s12 m6 l3 display-flex align-items-center show-btn">
                                <button type="submit" class="btn btn-block indigo waves-effect waves-light">Show</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="users-list-table">
                <div class="card">
                    <div class="card-content">
                        <!-- datatable start -->
                        <div class="responsive-table">
                            <table id="users-list-datatable" class="table">
                                <thead>
                                    <tr>
                                        <th>username</th>
                                        <th>name</th>
                                        <th>verified</th>
                                        <th>role</th>
                                        <th>status</th>
                                        <th>edit</th>
                                        <th>view</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (json_decode($response) as $user)
                                    <tr>
                                        <td>{{ $user->uname }}</td>
                                        <td><a href="{{ asset('page-users-view') }}">{{ strtoupper($user->sname) }}, {{ ucfirst($user->oname) }}</a>
                                        </td>
                                        <td>No</td>
                                        <td>
                                            {{  $user->role }}</td>
                                        <td><span class="chip green lighten-5">
                                                <span class="green-text">Active</span>
                                            </span>
                                        </td>
                                        <td><a href="{{ asset('page-users-edit') }}"><i class="material-icons">edit</i></a>
                                        </td>
                                        <td><a href="{{ asset('page-users-view') }}"><i
                                                    class="material-icons">remove_red_eye</i></a></td>
                                    </tr>
                                    @endforeach
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>username</th>
                                        <th>name</th>
                                        <th>verified</th>
                                        <th>role</th>
                                        <th>status</th>
                                        <th>edit</th>
                                        <th>view</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- datatable ends -->
                    </div>
                </div>
            </div>
        </section>

    @endsection


    {{-- vendor scripts --}}
    @section('vendor-script')
        <script src="{{ asset('vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
        {{-- <script src="{{ asset('vendors/data-tables/js/dataTables.select.min.js') }}"></script> --}}
    @endsection

    {{-- page script --}}
    @section('page-script')
        <script src="{{ asset('js/scripts/page-users.js') }}"></script>
        {{-- <script src="{{ asset('js/scripts/data-tables.js') }}"></script> --}}
        <script src="{{ asset('js/scripts/ui-alerts.js') }}"></script>
    @endsection
