{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Posts List')

{{-- vendors styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/select.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/select2/select2-materialize.css') }}">
@endsection

{{-- page styles --}}
@section('page-style')
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/page-users.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/data-tables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/form-select2.css') }}">
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
                                <a class="waves-effect waves-light btn modal-trigger mb-2 mr-1" href="{{ route('posts-add') }}">
                                    {{-- <a class="waves-effect waves-light btn modal-trigger mb-2 mr-1" href="#new-user"> --}}
                                   
                                    <i class="material-icons left">add_circle_outline</i>
                                    Create New Post
                                </a>
                            </div>
                        </div>
                        <h4 class="card-title">All Posts</h4>
                        <div class="row">
                            <div class="col s12">
                                <table id="page-length-option" class="display">
                                    <thead>
                                        <tr>
                                            <th>Post Title</th>
                                            <th>Class</th>
                                            <th>Created By</th>
                                            <th>Status</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (json_decode($response) as $post)
                                        <tr>
                                            <td>{{ $post->postTitle }}</td>
                                            <td>
                                                @php
                                                    $id_token = session()->get('id_Token');
                                                    $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses/'.$post->class);
                                                    $class = json_decode($response);
                                                @endphp
                                            {{ $class->name }}
                                            </td>
                                            <td>
                                                {{-- {{ $post->postedBy }} --}}
                                                <b>Posted By:</b>
                                                @php
                                                    $id_token = session()->get('id_Token');
                                                    $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/users/'.$post->postedBy);
                                                    $user = json_decode($response);
                                                @endphp
                                                {{ strtoupper($user->sname) }}, {{ ucwords($user->oname) }} <br>
                                                @php
                                                     if($user->role == 'SDM'){
                                                        echo "<b>(Super Admin)</b>";
                                                    }elseif  ($user->role == 'ADM') {
                                                        echo "<b>(Admin)</b>";
                                                    }elseif ($user->role == 'TEA') {
                                                        echo "<b>(Teacher)</b>";
                                                    }elseif ($user->role == 'STD') {
                                                        echo "<b>(Student)</b>";
                                                    }else {
                                                        echo "<b>Invalid Post</b>";
                                                    }
                                                @endphp
                                            </td>
                                            <td>
                                                @if ($post->status == 'active')
                                                    <span class="chip green lighten-5">
                                                        <span class="green-text">Active</span>
                                                    </span>
                                                @endif
                                                @if ($post->status == 'disabled')
                                                    <span class="chip red lighten-5">
                                                        <span class="red-text">Disabled</span>
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('posts-edit', ['id' => $post->id]) }}" class=" modal-trigger mr-5">
                                                    {{-- <a href="#e{{ $post->id }}" class=" modal-trigger mr-5"> --}}
                                                    <i class="material-icons">edit</i>
                                                </a>
                                                <a href="{{ route('posts-view', ['id' => $post->id]) }}"
                                                        class="mr-5">
                                                        <i class="material-icons">remove_red_eye</i>
                                                    </a>
                                                <a href="#{{ $post->id }}" class=" modal-trigger mr-5">
                                                    <i class="material-icons">delete</i>
                                                </a>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col s12">
                                                        <div id="{{ $post->id }}" class="modal">
                                                            <div class="modal-content">
                                                                <h6>Delete Post</h6>
                                                                <p>Are you sure you want to delete
                                                                    <b>{{ $post->postTitle }}</b> from the Post Records?
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="#"
                                                                    class="modal-action modal-close waves-effect waves-red btn-flat ">No,
                                                                    Cancel</a>
                                                                <a href="{{ route('posts-delete', ['id' => $post->id]) }}"
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
                                            <th>Post Title</th>
                                            <th>Class</th>
                                            <th>Created By</th>
                                            <th>Status</th>
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

@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{ asset('vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendors/data-tables/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('vendors/select2/select2.full.min.js') }}"></script>
@endsection

{{-- page script --}}
@section('page-script')
    <script src="{{ asset('js/scripts/data-tables.js') }}"></script>
    <script src="{{ asset('js/scripts/advance-ui-modals.js') }}"></script>
    <script src="{{ asset('js/scripts/ui-alerts.js') }}"></script>
    <script src="{{ asset('js/scripts/form-select2.js') }}"></script>
@endsection
