{{-- layout --}}
@extends('layouts.fullLayoutMaster')

{{-- page title --}}
@section('title', 'User Login')

{{-- page style --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/login.css') }}">
@endsection

{{-- page content --}}
@section('content')
    <div id="login-page" class="row">

        <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8">
            <form class="login-form" method="POST" action="{{ route('auth') }}">
                @csrf
                <div class="row">
                    <div class="input-field col s12">
                        <h5 class="ml-4">Sign in</h5>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">

                        @if ($errors->any())
                            <div class="card-alert card red lighten-1">
                                <div class="card-content white-text">
                                    <p>
                                        <i class="material-icons">error</i> ERROR :
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </p>
                                </div>
                                <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        @endif

                        @if (session()->has('val_errors'))
                            <div class="card-alert card red lighten-1">
                                @foreach (session()->get('val_errors') as $k => $v)
                                    <div class="card-content white-text">
                                        <p>
                                            <?php
                                            $msg = array_values($v);
                                            ?>
                                            <i class="material-icons">error</i> SUCCESS : <li>{{ $msg[0][0] }}</li>
                                        </p>
                                    </div>
                                @endforeach
                                <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        @endif

                        @if (session()->has('error'))
                            <div class="card-alert card red lighten-1">
                                <div class="card-content white-text">
                                    <p>
                                        <i class="material-icons">error</i> ERROR : {{ session()->get('error') }}
                                    </p>
                                </div>
                                <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        @endif

                        @if (session()->has('success'))
                            <div class="card-alert card green">
                                <div class="card-content white-text">
                                    <p>
                                        <i class="material-icons">check</i> ERROR : {{ session()->get('success') }}
                                    </p>
                                </div>
                                <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        @endif

                    </div>
                </div>

                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="material-icons prefix pt-2">person_outline</i>
                        <input id="username" type="text" name='uname'>
                        <label for="username" class="center-align">Username</label>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="material-icons prefix pt-2">lock_outline</i>
                        <input id="password" type="password" name='pword'>
                        <label for="password">Password</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m12 l12 ml-2 mt-1">
                        <p>
                            <label>
                                <input type="checkbox" />
                                <span>Remember Me</span>
                            </label>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        {{-- <a href="{{asset('/')}}"
            {{-- class="btn mycolor border-round col s12">Login</a> --
            class="btn border-round col s12">Login</a> --}}
                        <button class="btn border-round col s12">Login</button>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6 m6 l6">
                        <p class="margin medium-small"><a href="{{ asset('register') }}">Register Now!</a></p>
                    </div>
                    <div class="input-field col s6 m6 l6">
                        <p class="margin right-align medium-small"><a href="{{ asset('user-forgot-password') }}">Forgot
                                password ?</a>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
