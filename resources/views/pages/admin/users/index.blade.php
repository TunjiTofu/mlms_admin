{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Users list')

{{-- vendors styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/page-users.css') }}">
@endsection

{{-- page content --}}
@section('content')
    <!-- users list start -->
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
                                    <option value="Admin">Admin</option>
                                    <option value="Teacher">Teacher</option>
                                    <option value="Student">Student</option>
                                </select>
                            </div>
                        </div>
                        <div class="col s12 m6 l3">
                            <label for="users-list-status">Status</label>
                            <div class="input-field">
                                <select class="form-control" id="users-list-status">
                                    <option value="">Any</option>
                                    <option value="Active">Active</option>
                                    <option value="Pending">Pending</option>
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
                                    <th>delete</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (json_decode($response) as $user)
                                    <tr>
                                        
                                        <td><a href="{{ asset('page-users-view') }}">{{ $user->uname }}</a>
                                        </td>
                                        <td>{{ strtoupper($user->sname) }}, {{ ucfirst($user->oname) }}</td>
                                        <td>No</td>
                                        <td>
                                            @if ($user->role == 'ADM')
                                                Admin
                                            @endif
                                            @if ($user->role == 'TEA')
                                                Teacher
                                            @endif
                                            @if ($user->role == 'STD')
                                                Student
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->status == 'active')
                                                <span class="chip green lighten-5">
                                                    <span class="green-text">Active</span>
                                                </span>
                                            @endif
                                            @if ($user->status == 'pending')
                                                <span class="chip orange lighten-5">
                                                    <span class="orange-text">Pending</span>
                                                </span>
                                            @endif
                                            @if ($user->status == 'banned')
                                                <span class="chip red lighten-5">
                                                    <span class="red-text">Banned</span>
                                                </span>
                                            @endif

                                        </td>
                                        <td><a href="{{ asset('page-users-edit') }}"><i
                                                    class="material-icons">edit</i></a>
                                        </td>
                                        {{-- <td><a href="{{ route('users-view',['id'=>$hashid->encode($user->id)])) }}"><i --}}
                                           
                                        <td><a href="{{ route('users-view',['id'=>$user->id]) }}"><i
                                                    class="material-icons">remove_red_eye</i></a></td>
                                        <td><a href="{{ asset('page-users-view') }}"><i
                                                    class="material-icons">delete</i></a></td>
                                                    <td></td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- datatable ends -->
                </div>
            </div>
        </div>
    </section>
    <!-- users list ends -->
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{ asset('vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
@endsection

{{-- page script --}}
@section('page-script')
    <script src="{{ asset('js/scripts/page-users.js') }}"></script>
@endsection
