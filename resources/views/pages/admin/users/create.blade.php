{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title')
    Create User
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
                <h5>Add New User</h5>
                </p>

                <div id="view-input-fields">
                    <div class="row">
                        <div class="col s12">
                            <form class="row" method="POST" action="{{ route('users-store') }}">
                                @csrf
                                <div class="col s12">
                                    <div class="input-field col s6">
                                        <input id="uname" type="text" name="uname" class="validate">
                                        <label for="uname">Username</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <input id="email3" type="email" name="email" class="validate">
                                        <label for="email3">Email</label>
                                    </div>
                                </div>
                                <div class="col s12">
                                    <div class="input-field col s6">
                                        <input id="last_name" name="sname" type="text">
                                        <label for="last_name">Surname</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <input id="first_name" name="fname" type="text" class="validate">
                                        <label for="first_name">First Name</label>
                                    </div>
                                </div>

                                <div class="col s12">
                                    <div class="input-field col s6">
                                        <select name="role">
                                            <option value="" disabled selected>Choose a Role</option>
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
                                        <input id="phone" type="text" name="phone" class="validate">
                                        <label for="phone">Phone Number</label>
                                    </div>
                                </div>

                                <div class="col s12">
                                    <div class="input-field col s6">
                                        <input id="password" type="password" name="pword" class="validate"
                                            placeholder="Provide a default password for this user">
                                        <label for="password">Default Password</label>
                                    </div>
                                    <div class="input-field col s6">
                                      <input id="conf_password" type="password" name="conf_pword" class="validate"
                                          placeholder="Confirm default password for this user">
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
                </div>

            </div>
        </div>
    </div>
@endsection