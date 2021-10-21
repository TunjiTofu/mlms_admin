{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'View Post Comments')

{{-- vendor styles --}}
@section('vendor-style')
    {{-- Quill Editor --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/quill/katex.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/quill/monokai-sublime.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/quill/quill.snow.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('vendors/quill/quill.bubble.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/sweetalert/sweetalert.css') }}">
@endsection

{{-- page style --}}
@section('page-style')
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/app-sidebar.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/app-email.css') }}">
@endsection

{{-- page content --}}
@section('content')
    <!-- users view start -->
    <div class="section users-view">
        <!-- users view media object start -->
        @php
            $id_token = session()->get('id_Token');
            $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses/' . $post->class);
            $class = json_decode($response);
            // dd($teacher)
        @endphp
        <div class="card-panel" style="background-color:{{ $class->color }}; color:#efe7e7">
            <div class="row">
                <div class="col s12 m12 l7">
                    <div class="display-flex media">
                        <div class="media-body">
                            <h6 class="media-heading" style="color: #efe7e7">
                                {{-- <span class="users-view-name">{{ $user->sname }}, {{ $user->oname }} </span>
                                <span class="grey-text">@</span> --}}
                                <span class="users-view-username"> <b>Post Title: </b>{{ $post->postTitle }}</span>
                            </h6>
                            <span><b>Post Status: </b></span>
                            <span class="users-view-id">
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
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col s12 m12 l5 quick-action-btns display-flex justify-content-end align-items-center pt-2">
                    {{-- <a href="{{ asset('app-email') }}" class="btn-small btn-light-indigo"><i
                            class="material-icons">mail_outline</i></a> --}}
                    <a class=" btn-warning-cancel btn-small btn-light-indigo" data-id="{{ $post->id }}"
                        data-title="{{ $post->postTitle }}">Delete
                        Post</a>
                    <a href="{{ route('posts-edit', ['id' => $post->id]) }}" class="btn-small btn-light-indigo">Edit
                        Post</a>
                    <a href="{{ asset('user-profile-page') }}" class="btn-small btn-light-indigo">View Post Comments</a>
                </div>
            </div>
        </div>
        <!-- users view media object ends -->
        {{-- Card Personal Info --}}
        <div class="card">
            <div class="card-content">


                <div class="row">
                    <div class="col s12">
                        <h6>
                            <i class="material-icons">comment</i>
                            Post Comments
                        </h6>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m8">
                        <div class="app-email">
                            <div class="content-area content-right">
                                <div class="app-wrapper">
                                    <div class=" scrollspy border-radius-6 fixed-width">
                                        <div class="card-content p-0 pb-2">
                                            <div class="collection email-collection">
                                                <div class="email-brief-info collection-item animate fadeUp delay-1">
                                                    <a class="list-content" href="{{ asset('app-email/content') }}">
                                                        <div class="list-title-area">
                                                            <div class="user-media">
                                                                <img src="{{ asset('images/user/2.jpg') }}" alt=""
                                                                    class="circle z-depth-2 responsive-img avtar">
                                                                <div class="list-title">Gorge Fernandis</div>
                                                            </div>
                                                            <div class="title-right">
                                                                <span class="list-date"> 2:03 PM </span>
                                                            </div>
                                                        </div>
                                                        <div class="list-desc">There are many variations of
                                                            passages of
                                                            Lorem
                                                            Ipsum
                                                            available, but the majority
                                                            have suffered alteration in some form, by injected humour,
                                                            or
                                                            randomised
                                                            words which
                                                            don't look even
                                                            slightly believable. If you are going to use a passage of
                                                            Lorem
                                                            Ipsum
                                                        </div>

                                                    </a>
                                                    <div>
                                                        {{-- <a href="{{ route('posts-edit', ['id' => $post->id]) }}"
                                                                class=" modal-trigger mr-5"> --}}
                                                        {{-- <a href="#e{{ $post->id }}" class=" modal-trigger mr-5"> --}}
                                                        <a href="#replyCommentId" class=" modal-trigger mr-5">
                                                            <i class="small material-icons">reply</i> Reply Comment
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="email-brief-info collection-item animate fadeUp delay-1">
                                                    <a class="list-content" href="{{ asset('app-email/content') }}">
                                                        <div class="list-title-area">
                                                            <div class="user-media">
                                                                <img src="{{ asset('images/user/10.jpg') }}" alt=""
                                                                    class="circle z-depth-2 responsive-img avtar">
                                                                <div class="list-title">Gorge Fernandis</div>
                                                            </div>
                                                            <div class="title-right">
                                                                <span class="list-date"> 2:03 PM </span>
                                                            </div>
                                                        </div>
                                                        <div class="list-desc">There are many variations of
                                                            passages of
                                                            Lorem
                                                            Ipsum
                                                            available, but the majority
                                                            have suffered alteration in some form, by injected humour,
                                                            or
                                                            randomised
                                                            words which
                                                            don't look even
                                                            slightly believable. If you are going to use a passage of
                                                            Lorem
                                                            Ipsum
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="email-brief-info collection-item animate fadeUp delay-1">
                                                    <a class="list-content" href="{{ asset('app-email/content') }}">
                                                        <div class="list-title-area">
                                                            <div class="user-media">
                                                                <img src="{{ asset('images/user/4.jpg') }}" alt=""
                                                                    class="circle z-depth-2 responsive-img avtar">
                                                                <div class="list-title">Gorge Fernandis</div>
                                                            </div>
                                                            <div class="title-right">
                                                                <span class="list-date"> 2:03 PM </span>
                                                            </div>
                                                        </div>
                                                        <div class="list-desc">There are many variations of
                                                            passages of
                                                            Lorem
                                                            Ipsum
                                                            available, but the majority
                                                            have suffered alteration in some form, by injected humour,
                                                            or
                                                            randomised
                                                            words which
                                                            don't look even
                                                            slightly believable. If you are going to use a passage of
                                                            Lorem
                                                            Ipsum
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="email-brief-info collection-item animate fadeUp delay-1">
                                                    <a class="list-content" href="{{ asset('app-email/content') }}">
                                                        <div class="list-title-area">
                                                            <div class="user-media">
                                                                <img src="{{ asset('images/user/6.jpg') }}" alt=""
                                                                    class="circle z-depth-2 responsive-img avtar">
                                                                <div class="list-title">Gorge Fernandis</div>
                                                            </div>
                                                            <div class="title-right">
                                                                <span class="list-date"> 2:03 PM </span>
                                                            </div>
                                                        </div>
                                                        <div class="list-desc">There are many variations of
                                                            passages of
                                                            Lorem
                                                            Ipsum
                                                            available, but the majority
                                                            have suffered alteration in some form, by injected humour,
                                                            or
                                                            randomised
                                                            words which
                                                            don't look even
                                                            slightly believable. If you are going to use a passage of
                                                            Lorem
                                                            Ipsum
                                                        </div>
                                                    </a>
                                                </div>


                                                <div class="email-brief-info collection-item animate fadeUp delay-3">
                                                    <div class="list-left">
                                                        <label>
                                                            <input type="checkbox" name="foo" />
                                                            <span></span>
                                                        </label>
                                                        <div class="favorite">
                                                            <i class="material-icons">star_border</i>
                                                        </div>
                                                        <div class="email-label">
                                                            <i class="material-icons">label_outline</i>
                                                        </div>
                                                    </div>
                                                    <a class="list-content" href="{{ asset('app-email/content') }}">
                                                        <div class="list-title-area">
                                                            <div class="user-media">
                                                                <img src="{{ asset('images/user/4.jpg') }}" alt=""
                                                                    class="circle z-depth-2 responsive-img avtar">
                                                                <div class="list-title">Alin Kystal</div>
                                                            </div>
                                                            <div class="title-right">
                                                                <span class="attach-file">
                                                                    <i class="material-icons">attach_file</i>
                                                                </span>
                                                                <span class="badge grey lighten-3"><i
                                                                        class="purple-text material-icons small-icons mr-2">
                                                                        fiber_manual_record </i>Note</span>
                                                            </div>
                                                        </div>
                                                        <div class="list-desc">There are many variations of
                                                            passages of
                                                            Lorem
                                                            Ipsum
                                                            available, but the majority
                                                            have suffered alteration in some form, by injected humour,
                                                            or
                                                            randomised
                                                            words which
                                                            don't look even
                                                            slightly believable. If you are going to use a passage of
                                                            Lorem
                                                            Ipsum
                                                        </div>
                                                    </a>
                                                    <div class="list-right">
                                                        <div class="list-date"> 8:18 AM </div>
                                                    </div>
                                                </div>




                                                <div class="row">
                                                    <div class="col s12">
                                                        <div id="replyCommentId" class="modal">
                                                            <div class="modal-content">
                                                                <h6>Reply Comment</h6>
                                                                <div class="row">
                                                                    <div class="col s12">
                                                                        <form class="row mt-1" id="replyComment"
                                                                            method="POST"
                                                                            action="{{ route('comments-store') }}">
                                                                            {{ csrf_field() }}
                                                                            <div class="input-field">
                                                                                <!-- Compose mail Quill editor -->
                                                                                <div class="snow-container snow-editor"
                                                                                    id="editorReply-container">
                                                                                    <div id="snow-wrapper">
                                                                                        <div id="snow-container">
                                                                                            <!-- Create the toolbar container -->
                                                                                            <div id="editorReplyComment">

                                                                                            </div>
                                                                                            <div id="toolbarReply"
                                                                                                class="compose-quill-toolbar">
                                                                                                <span
                                                                                                    class="ql-formats mr-0">
                                                                                                    <button
                                                                                                        class="ql-bold"
                                                                                                        title="Bold"></button>
                                                                                                    <button
                                                                                                        class="ql-italic"
                                                                                                        title="Italics"></button>
                                                                                                    <button
                                                                                                        class="ql-underline"
                                                                                                        title="Underline"></button>
                                                                                                    <button
                                                                                                        class="ql-link"
                                                                                                        title="Embed Link"></button>
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- End of Quill Rich Text Editor -->
                                                                            </div>
                                                                            <textarea name="replyComment"
                                                                                style="display:none"
                                                                                id="hiddenAreaReplyComment"></textarea>

                                                                            <div class="col s12">
                                                                                <div class="input-field col s12">
                                                                                    <button
                                                                                        class="btn border-round col s12">Update
                                                                                        Module</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>





                                            </div> <!-- Stop Cut here -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End Col -->

                    <form class="row mt-1" id="myForm" method="POST" action="{{ route('comments-store') }}">
                        {{ csrf_field() }}
                        <div class="col s12 m4">
                            <div class="input-field">
                                <!-- Compose mail Quill editor -->
                                <div class="snow-container snow-editor" id="editor-container">
                                    <div id="snow-wrapper">
                                        <div id="snow-container">
                                            <!-- Create the toolbar container -->
                                            <div id="editor">

                                            </div>
                                            <div id="toolbar" class="compose-quill-toolbar">
                                                <span class="ql-formats mr-0">
                                                    <button class="ql-bold" title="Bold"></button>
                                                    <button class="ql-italic" title="Italics"></button>
                                                    <button class="ql-underline" title="Underline"></button>
                                                    <button class="ql-link" title="Embed Link"></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Quill Rich Text Editor -->
                            </div>
                            <textarea name="postContent" style="display:none" id="hiddenAreaContent"></textarea>

                            <div class="row">
                                <div class="col s12">
                                    <div class="input-field col s12">
                                        <button class="btn border-round col s5 m5"><i
                                                class="material-icons left">send</i>Comment</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>




        {{-- End Card Personal Info --}}

        <!-- users view card data start -->
        {{-- <div class="card">
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
        </div> --}}
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

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{ asset('vendors/quill/katex.min.js') }}"></script>
    <script src="{{ asset('vendors/quill/highlight.min.js') }}"></script>
    <script src="{{ asset('vendors/quill/quill.min.js') }}"></script>
    <script src="{{ asset('vendors/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('vendors/sweetalert/sweetalert.min.js') }}"></script>
@endsection

{{-- page script --}}
@section('page-script')
    <script src="{{ asset('js/scripts/form-select2.js') }}"></script>
    <script src="{{ asset('js/scripts/ui-alerts.js') }}"></script>
    <script src="{{ asset('js/scripts/app-email.js') }}"></script>
    <script src="{{ asset('js/scripts/advance-ui-modals.js') }}"></script>

    <!-- Initialize Quill editor -->
    {{-- <script src="{{ asset('js/scripts/form-editor.js') }}"></script>
    <script>
        var quill = new Quill('#editor', {
            placeholder: 'No Content Here...',
            bounds: '#editor-container',
            readOnly: true,
        });
    </script> --}}

    <script src="{{ asset('js/scripts/extra-components-sweetalert.js') }}"></script>

    <script>
        $('.btn-warning-cancel').click(function() {
            var deleteButnData = $(this);
            var dataId = deleteButnData.data('id');
            var dataTitle = deleteButnData.data('title');
            swal({
                title: "Delete Record?",
                text: 'Are you sure you want to delete \"' + dataTitle +
                    '\" from the Post Records? You will not be able to recover this imaginary file!',
                icon: 'warning',
                dangerMode: true,
                buttons: {
                    cancel: 'No, Cancel',
                    delete: 'Yes, Delete It'
                }
            }).then(function(willDelete) {
                if (willDelete) {
                    console.log("ID - " + dataId);
                    // console.log("dataTitle - " + dataTitle);
                    jQuery.ajax({
                        url: "/posts/delete/" + dataId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {}
                    });

                    swal("\"" + dataTitle + "\" record has been deleted!", {
                        icon: "success",
                    });

                    $(location).attr('href', '/posts'); //Refressh the page

                } else {
                    swal("Your record is safe", {
                        title: 'Cancelled',
                        icon: "error",
                    });
                }
            });
        });
    </script>

    <script>
        var quill = new Quill('#editor', {
            modules: {
                toolbar: '#toolbar'
            },
            theme: 'snow',
            placeholder: 'Write a Comment...',
            bounds: '#editor-container'
        });

        $("#myForm").on("submit", function() {
            $("#hiddenAreaContent").val($("#editor .ql-editor").html());
        });
    </script>

    <script>
        var quill = new Quill('#editorReplyComment', {
            modules: {
                toolbar: '#toolbarReply'
            },
            theme: 'snow',
            placeholder: 'Write a Comment...',
            bounds: '#editorReply-container'
        });

        $("#replyComment").on("submit", function() {
            $("#hiddenAreaReplyComment").val($("#editorReplyComment .ql-editor").html());
        });
    </script>
@endsection
