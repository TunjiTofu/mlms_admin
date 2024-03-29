{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'View Class Details')

{{-- page style --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/page-users.css') }}">
@endsection

{{-- page content --}}
@section('content')
    <!-- users view start -->
    <div class="section users-view">
        <!-- users view media object start -->
        <div class="card-panel" style="background-color:{{ $class->color }}; color:#efe7e7">
            <div class="row">
                <div class="col s12 m12 l7">
                    <div class="display-flex media">
                        <a href="#" class="avatar">
                            <img src="{{ asset('images/avatar/avatar-15.png') }}" alt="users view avatar"
                                class="z-depth-4 circle" height="64" width="64">

                        </a>
                        <div class="media-body">
                            <h6 class="media-heading" style="color: #efe7e7">
                                {{-- <span class="users-view-name">{{ $user->sname }}, {{ $user->oname }} </span>
                                <span class="grey-text">@</span> --}}
                                <span class="users-view-username"> <b>Class Name: </b>{{ $class->name }}</span>
                            </h6>
                            <span><b>Class Code: </b></span>
                            <span class="users-view-id">{{ $class->classCode }}</span>
                        </div>
                    </div>
                </div>
                <div class="col s12 m12 l5 quick-action-btns display-flex justify-content-end align-items-center pt-2">
                    {{-- <a href="{{ asset('app-email') }}" class="btn-small btn-light-indigo"><i
                            class="material-icons">mail_outline</i></a> --}}
                    <a href="{{ route('classes-edit', ['id' => $class->id]) }}" class="btn-small btn-light-indigo">Edit
                        Class Info</a>
                    <a href="{{ asset('user-profile-page') }}" class="btn-small btn-light-indigo">View Teachers'
                        Profile</a>
                </div>
            </div>
        </div>
        <!-- users view media object ends -->
        {{-- Card Personal Info --}}
        <div class="card">
            <div class="card-content">
                <div class="row">
                    <div class="col s12">
                        <h6 class="mb-2 mt-2">
                            <i class="material-icons">class</i>
                            Class Info
                        </h6>
                        <table class="striped">
                            <tbody>
                                <tr>
                                    <td>Class Description:</td>
                                    <td class="users-view-name">{{ $class->description }}</td>
                                </tr>
                                <tr>
                                    <td>Class Teacher:</td>
                                    <td class="users-view-email">
                                        @php
                                            $id_token = session()->get('id_Token');
                                            $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/users/' . $class->teacher);
                                            $teacher = json_decode($response);
                                            // dd($teacher)
                                        @endphp
                                        {{ strtoupper($teacher->sname) }}, {{ ucwords($teacher->oname) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Class Status:</td>
                                    <td class="users-view-latest-activity">
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
                                </tr>
                                <tr>
                                    <td>Created By Admin:</td>
                                    <td>
                                        @if ($class->createdByAdmin == false)
                                            <span class="chip green lighten-5">
                                                <span class="green-text">No</span>
                                            </span>
                                        @endif
                                        @if ($class->createdByAdmin == true)
                                            <span class="chip red lighten-5">
                                                <span class="red-text">Yes</span>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date Created:</td>
                                    <td>
                                        @php
                                            $timestamp = $class->createdAt->_seconds;
                                            date_default_timezone_set('Africa/Lagos');
                                            echo date('d-M-Y h:i a', $timestamp);
                                        @endphp
                                    </td>
                                </tr>
                                <tr>
                                    <td>Last Updated By:</td>
                                    <td>
                                        @if ($class->updatedByAdmin == "Yes")
                                            Admin
                                        @else
                                            {{ $class->updatedByAdmin }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date Updated:</td>
                                    <td>
                                        @php
                                            $timestamp2 = $class->updatedAt->_seconds;
                                            date_default_timezone_set('Africa/Lagos');
                                            echo date('d-M-Y h:i a', $timestamp2);
                                        @endphp
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Card Personal Info --}}

        <!-- users view card data start -->
        <div class="card">
            <div class="card-content">
                <div class="row">
                    <div class="col s12 m4">
                        <h6 class="mb-2 mt-2"><i class="material-icons">person_outline</i> Enrolled Students</h6>
                        <table class="striped">
                            <tbody>

                                <tr>
                                    <td>Last Activity:</td>
                                    <td>{{ '$userAuth->metadata->lastSignInTime' }}</td>
                                </tr>
                                <tr>
                                    <td>Verified:</td>
                                    <td class="users-view-verified">
                                        @if ('$userAuth->emailVerified' == false)
                                            <span class="chip red lighten-5">
                                                <span class="red-text">No</span>
                                            </span>
                                        @endif
                                        @if ('$userAuth->emailVerified' == true)
                                            <span class="chip green lighten-5">
                                                <span class="green-text">Yes</span>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Role:</td>
                                    <td class="users-view-role">
                                        @if ('$userAuth->customClaims->role' == 'SDM')
                                            <span class="chip purple lighten-5">
                                                <span class="purple-text">Super Administrator</span>
                                            </span>
                                        @endif
                                        @if ('$userAuth->customClaims->role' == 'ADM')
                                            <span class="chip pink lighten-5">
                                                <span class="pink-text">Administrator</span>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Status:</td>
                                    <td>
                                        @if ('$userAuth->customClaims->status' == 'active')
                                            <span class="chip green lighten-5">
                                                <span class="green-text">Active</span>
                                            </span>
                                        @endif
                                        @if ('$userAuth->customClaims->status' == 'banned')
                                            <span class="chip red lighten-5">
                                                <span class="red-text">Banned</span>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col s12 m8">
                        <table class="responsive-table">
                            <thead>
                                <tr>
                                    <th>Module Permission</th>
                                    <th>Read</th>
                                    <th>Write</th>
                                    <th>Create</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Users</td>
                                    <td>Yes</td>
                                    <td>No</td>
                                    <td>No</td>
                                    <td>Yes</td>
                                </tr>
                                <tr>
                                    <td>Articles</td>
                                    <td>No</td>
                                    <td>Yes</td>
                                    <td>No</td>
                                    <td>Yes</td>
                                </tr>
                                <tr>
                                    <td>Staff</td>
                                    <td>Yes</td>
                                    <td>Yes</td>
                                    <td>No</td>
                                    <td>No</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- users view card data ends -->


        <!-- users view card details start -->
        {{-- <div class="card">
            <div class="card-content">
                <div class="row indigo lighten-5 border-radius-4 mb-2">
                    <div class="col s12 m4 users-view-timeline">
                        <h6 class="indigo-text m-0">Posts: <span>125</span></h6>
                    </div>
                    <div class="col s12 m4 users-view-timeline">
                        <h6 class="indigo-text m-0">Followers: <span>534</span></h6>
                    </div>
                    <div class="col s12 m4 users-view-timeline">
                        <h6 class="indigo-text m-0">Following: <span>256</span></h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <table class="striped">
                            <tbody>
                                <tr>
                                    <td>Username:</td>
                                    <td class="users-view-username">dean3004</td>
                                </tr>
                                <tr>
                                    <td>Name:</td>
                                    <td class="users-view-name">Dean Stanley</td>
                                </tr>
                                <tr>
                                    <td>E-mail:</td>
                                    <td class="users-view-email">deanstanley@gmail.com</td>
                                </tr>
                                <tr>
                                    <td>Comapny:</td>
                                    <td>XYZ Corp. Ltd.</td>
                                </tr>

                            </tbody>
                        </table>
                        <h6 class="mb-2 mt-2"><i class="material-icons">link</i> Social Links</h6>
                        <table class="striped">
                            <tbody>
                                <tr>
                                    <td>Twitter:</td>
                                    <td><a href="#">https://www.twitter.com/</a></td>
                                </tr>
                                <tr>
                                    <td>Facebook:</td>
                                    <td><a href="#">https://www.facebook.com/</a></td>
                                </tr>
                                <tr>
                                    <td>Instagram:</td>
                                    <td><a href="#">https://www.instagram.com/</a></td>
                                </tr>
                            </tbody>
                        </table>
                        <h6 class="mb-2 mt-2"><i class="material-icons">error_outline</i> Personal Info</h6>
                        <table class="striped">
                            <tbody>
                                <tr>
                                    <td>Birthday:</td>
                                    <td>03/04/1990</td>
                                </tr>
                                <tr>
                                    <td>Country:</td>
                                    <td>USA</td>
                                </tr>
                                <tr>
                                    <td>Languages:</td>
                                    <td>English</td>
                                </tr>
                                <tr>
                                    <td>Contact:</td>
                                    <td>+(305) 254 24668</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- </div> -->
            </div>
        </div> --}}
        <!-- users view card details ends -->

    </div>
    <!-- users view ends -->
@endsection

{{-- page script --}}
@section('page-script')
    {{-- <script src="{{ asset('js/scripts/page-users.js') }}"></script> --}}
    <script src="{{ asset('js/scripts/ui-alerts.js') }}"></script>
@endsection
