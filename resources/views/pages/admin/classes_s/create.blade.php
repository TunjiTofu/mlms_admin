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
                <h5>Create New Class</h5>
                </p>

                <div id="view-input-fields">
                    <div class="row">
                        <div class="col s12">
                            <form class="row" method="POST" action="{{ route('users-store') }}">
                                {{ csrf_field() }}
                                <div class="col s12">
                                    <div class="input-field col s6">
                                        <input id="uname" type="text" name="uname" class="validate" required size="6"
                                            maxlength="6" style="text-transform:uppercase">
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
                                            {{-- @foreach (json_decode($responsePriv) as $privilege)
                                                <option value="{{ $privilege->id }}">{{ $privilege->title }}</option>
                                            @endforeach --}}
                                        </select>
                                        <label>Role</label>
                                    </div>

                                    <div class="input-field col s6">
                                        <select name="status">
                                            <option value="" disabled selected>Choose a Status</option>
                                            {{-- @foreach (json_decode($responseUserStatus) as $userStatus)
                                                <option value="{{ $userStatus->id }}">{{ $userStatus->status }}</option>
                                            @endforeach --}}
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
                                        <input id="conf_password" type="password" name="pword_confirmation"
                                            class="validate" placeholder="Confirm default password for this user"
                                            required>
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
