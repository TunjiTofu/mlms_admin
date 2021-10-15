{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Quiz Types')

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
                                    Create New Quiz Type
                                </a>
                            </div>
                        </div>
                        <h4 class="card-title">All Quiz Types</h4>
                        <div class="row">
                            <div class="col s12">
                                <table id="page-length-option" class="display">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Quiz Type</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (json_decode($response) as $quizType)
                                            <tr>
                                                <td>{{ $quizType->id }}</td>
                                                <td>{{ $quizType->type }}</td>
                                                <td>
                                                    <a href="#e{{ $quizType->id }}" class="modal-trigger mr-5">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    {{-- <a href="{{ route('users-view', ['id' => '123']) }}"
                                                    class="mr-5">
                                                    <i class="material-icons">remove_red_eye</i>
                                                </a> --}}
                                                    <a href="#{{ $quizType->id }}" class="modal-trigger mr-5">
                                                        <i class="material-icons">delete</i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col s12">
                                                            <div id="e{{ $quizType->id }}" class="modal">
                                                                <div class="modal-content">
                                                                    <h6>Edit Quiz Type</h6>
                                                                    <form class="row" method="POST"
                                                                        action="{{ route('quiztype-update', ['id' => $quizType->id]) }}">
                                                                        @csrf
                                                                        {{ method_field('PATCH') }}
                                                                        <div class="col s12">
                                                                            <div class="input-field col s12">
                                                                                <input id="type" type="text" name="type"
                                                                                    class="validate" required
                                                                                    value="{{ $quizType->type }}">
                                                                                <label for="type">Quiz Type</label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col s12">
                                                                            <div class="input-field col s12">
                                                                                <button
                                                                                    class="btn border-round col s12">Update
                                                                                    Quiz Type</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col s12">
                                                            <div id="{{ $quizType->id }}" class="modal">
                                                                <div class="modal-content">
                                                                    <h6>Delete Quiz Type</h6>
                                                                    <p>Are you sure you want to delete
                                                                        <b>{{ $quizType->id }}</b> from the Quiz Type list?</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <a href="#"
                                                                        class="modal-action modal-close waves-effect waves-red btn-flat ">No,
                                                                        Cancel</a>
                                                                    <a href="{{ route('quiztype-delete', ['id' => $quizType->id]) }}"
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
                                            <th>ID</th>
                                            <th>Quiz Type</th>
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
            <h6>Create a New Quiz Type</h6>
            <form class="row" method="POST" action="{{ route('quiztype-store') }}">
                {{ csrf_field() }}
                <div class="col s12">
                    <div class="input-field col s12 m6">
                        <input id="id" type="text" name="id" class="validate" required>
                        <label for="id">Id</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="type" type="text" name="type" class="validate" required>
                        <label for="type">Quiz Type</label>
                    </div>
                </div>

                <div class="col s12">
                    <div class="input-field col s12">
                        <button class="btn border-round col s12">Create Quiz Type</button>
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
    <script src="{{asset('js/scripts/ui-alerts.js')}}"></script>
@endsection
