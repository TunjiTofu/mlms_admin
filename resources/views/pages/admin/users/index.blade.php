{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Users List')

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
                    <div class="row">
                        <div class="col s12 m6 l3">
                            <a class="waves-effect waves-light btn modal-trigger mb-2 mr-1" href="#new-user">Create New
                                User</a>
                        </div>
                    </div>
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
                                        <td><a href="{{ route('users-edit', ['id' => $user->id]) }}"><i
                                                    class="material-icons">edit</i></a>
                                        </td>
                                        {{-- <td><a href="{{ route('users-view',['id'=>$hashid->encode($user->id)])) }}"><i --}}

                                        <td><a href="{{ route('users-view', ['id' => $user->id]) }}"><i
                                                    class="material-icons">remove_red_eye</i></a></td>
                                        <td>
                                            <a href="#{{ $user->id }}" class=" modal-trigger"><i
                                                    class="material-icons">delete</i></a>

                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col s12">
                                                    <div id="{{ $user->id }}" class="modal">
                                                        <div class="modal-content">
                                                            <h6>Delete User</h6>
                                                            <p>Are you sure you want to delete <b>{{ strtoupper($user->sname) }}, {{ ucfirst($user->oname) }}</b>?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="#"
                                                                class="modal-action modal-close waves-effect waves-red btn-flat ">No,
                                                                Cancel</a>
                                                            <a href="{{ route('users-delete', ['id' => $user->id]) }}"
                                                                class="modal-action modal-close waves-effect waves-green btn-flat ">Yes,
                                                                Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
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

        <div id="new-user" class="modal">
            <div class="modal-content">
                <h6>Create a New User</h6>
                <form class="row" method="POST" action="{{ route('users-store') }}">
                    {{ csrf_field() }}
                    <div class="col s12">
                        <div class="input-field col s6">
                            <input id="uname" type="text" name="uname" class="validate" required min="4" max="6"
                                value="{{ old('uname') }}">
                            <label for="uname">Username</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="email3" type="email" name="email" class="validate" required
                                value="{{ old('email') }}">
                            <label for="email3">Email</label>
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="input-field col s6">
                            <input id="last_name" name="sname" type="text" required>
                            <label for="last_name">Surname</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="first_name" name="oname" type="text" class="validate" required>
                            <label for="first_name">Other Names</label>
                        </div>
                    </div>

                    <div class="col s12">
                        <div class="input-field col s6">
                            <select name="role">
                                <option value="0" disabled selected>Choose a Role</option>
                                <option value="ADM">Admin</option>
                                <option value="TEA">Teacher</option>
                                <option value="STD">Student</option>
                            </select>
                            <label>Role</label>
                        </div>

                        <div class="input-field col s6">
                            <select name="status">
                                <option value="" disabled selected>Choose a Status</option>
                                <option value="active">Active</option>
                                <option value="pending">Pending</option>
                                <option value="banned">Banned</option>
                            </select>
                            <label>Status</label>
                        </div>
                    </div>

                    <div class="col s12">
                        <div class="input-field col s6">
                            <input id="phone" type="text" name="phone" class="validate" required max="11">
                            <label for="phone">Phone Number</label>
                        </div>
                    </div>

                    <div class="col s12">
                        <div class="input-field col s6">
                            <input id="password" type="password" name="pword" class="validate"
                                placeholder="Provide a default password for this user" required>
                            <label for="password">Default Password</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="conf_password" type="password" name="pword_confirmation" class="validate"
                                placeholder="Confirm default password for this user" required>
                            <label for="conf_password">Confirm Default Password</label>
                        </div>
                    </div>

                    <div class="col s12">
                        <div class="input-field col s12">
                            <button class="btn border-round col s12">Create User</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </section>
    <!-- users list ends -->



    <script>
        function myFunction() {
            // if(!confirm("Are You Sure to delete this"))
            // event.preventDefault();

        }
    </script>
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{ asset('vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
@endsection

{{-- page script --}}
@section('page-script')
    <script src="{{ asset('js/scripts/page-users.js') }}"></script>
    <script src="{{ asset('js/scripts/advance-ui-modals.js') }}"></script>
@endsection
