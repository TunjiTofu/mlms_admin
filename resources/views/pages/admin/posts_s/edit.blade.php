{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title')
    Edit Post
@endsection

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/flag-icon/css/flag-icon.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/noUiSlider/nouislider.min.css') }}">

    {{-- Select 2 --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/select2/select2-materialize.css') }}">

    {{-- Quill Editor --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/quill/katex.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/quill/monokai-sublime.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/quill/quill.snow.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('vendors/quill/quill.bubble.css') }}"> --}}
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/form-select2.css') }}">
@endsection

{{-- page content --}}
@section('content')


    <div class="section">
        <div class="card">
            <div class="card-content">
                <p class="caption mb-0">
                <h6>Edit Post</h6>
                <form class="row" id="myForm" method="POST"
                    action="{{ route('posts-update', ['id' => $post->id]) }}">
                    @csrf
                    {{ method_field('PATCH') }}
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12">
                                <input id="title" type="text" name="postTitle" class="validate"
                                    value="{{ $post->postTitle }}" required>
                                <label for="code">Post Title</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Quill Rich Text Editor -->
                        <div class="snow-editor col s12" id="editor-container">
                            <div id="snow-wrapper">
                                <div id="snow-container">
                                    <!-- Create the toolbar container -->
                                    <div id="toolbar">
                                        <span class="ql-formats">
                                            <button class="ql-bold" title="Bold"></button>
                                            <button class="ql-italic" title="Italics"></button>
                                            <button class="ql-strike" title="Strikethrough"></button>
                                            <button class="ql-underline" title="Underline"></button>
                                            <button class="ql-script" value="sub" title="Subscript"></button>
                                            <button class="ql-script" value="super" title="Superscript"></button>
                                        </span>

                                        <span class="ql-formats">
                                            <select class="ql-header browser-default" title="Heading Size">
                                                <option selected value="false">Heading</option>
                                                <option value="1">Heading 1</option>
                                                <option value="2">Heading 2</option>
                                                <option value="3">Heading 3</option>
                                                <option value="4">Heading 4</option>
                                                <option value="5">Heading 5</option>
                                                <option value="6">Heading 6</option>
                                            </select>

                                            <span class="ql-header browser-default">
                                                <select class="ql-size browser-default" title="Font Sizes">
                                                    <option selected value="false">Text Sizes</option>
                                                    <option value="small">small</option>
                                                    <option value="large">large</option>
                                                    <option value="huge">huge</option>
                                                </select>
                                            </span>

                                            <select class="ql-font browser-default" title="Font Styles">
                                                <option selected>Sailec Light</option>
                                                <option value="comic sans">Comic Sans</option>
                                                <option value="sofia">Sofia Pro</option>
                                                <option value="slabo">Slabo 27px</option>
                                                <option value="roboto">Roboto Slab</option>
                                                <option value="inconsolata">Inconsolata</option>
                                                <option value="ubuntu">Ubuntu Mono</option>
                                            </select>

                                        </span>
                                        <span class="ql-formats">
                                            <select class="ql-color browser-default" title="Text Color">
                                            </select>
                                            <select class="ql-background browser-default" title="Background Color">
                                            </select>
                                        </span>

                                        <span class="ql-formats">
                                            <button class="ql-list" value="ordered" title="Bullets"></button>
                                            <button class="ql-list" value="bullet" title="Number"></button>
                                            <button class="ql-indent" value="+1" title="Indent Inward"></button>
                                            <button class="ql-indent" value="-1" title="Indent Outward"></button>
                                            <select class="ql-align browser-default" title="Align Text">
                                            </select>
                                        </span>
                                        <span class="ql-formats">
                                            <button class="ql-link" title="Embed Link"></button>
                                            <button class="ql-image" title="Embed Image"></button>
                                            <button class="ql-video" title="Embed Video"></button>
                                        </span>
                                        <span class="ql-formats">
                                            <button class="ql-formula" title="Insert Formular"></button>
                                            <button class="ql-code-block" title="Insert Code Block"></button>
                                        </span>
                                        <span class="ql-formats">
                                            <button class="ql-clean" title="Remove Formatting Button"></button>
                                        </span>
                                    </div>

                                    <!-- Create the editor container -->
                                    {{-- <label for="about">About me</label> --}}
                                    {{-- <textarea class="materialize-textarea"  id="editor-textarea" name="about"></textarea> --}}
                                    <div id="editor">
                                        {!! $post->postContent !!}
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- End of Quill Rich Text Editor -->
                    </div>

                    <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12">
                                <h>Status</h>
                                <select name="status" id="status" class="select2 browser-default">
                                    <option value="" disabled selected>Select Status</option>
                                    @foreach (json_decode($responseStatus) as $status)
                                        <option value="{{ $status->id }}"
                                            {{ $status->id == $post->status ? 'selected = "selected"' : '' }}>
                                            {{ $status->status }}
                                        </option>
                                    @endforeach
                                </select>
                                {{-- <label>Status</label> --}}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12">
                                <h>Class</h>
                                <select name="classList" id="classList" class="select2 browser-default">
                                    <option value="" disabled selected>Select Class</option>
                                    @foreach (json_decode($responseClasses) as $class)
                                        <option value="{{ $class->id }}"
                                            {{ $class->id == $post->class ? 'selected = "selected"' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <span class="helper-text" style="color: red">**********</span> <br>
                    <span class="helper-text" style="color: red">Re-select the class name to change any of the options
                        below. Leave blank if previous options are OK</span>
                    <hr>
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12">
                                @php
                                    $id_token = session()->get('id_Token');
                                    $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminModules/' . $post->module);
                                    $module = json_decode($response);
                                    // dd($teacher)
                                @endphp
                                <input type="hidden" value="{{ $module->id }}" name="currentModule" readonly>
                                <input type="text" value="{{ $module->moduleName }}" disabled readonly>
                                <label for="code">Current Module </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12">
                                <h>Select New Module</h>
                                <select name="module" id="module" class="select2 browser-default">
                                    <option value="">--</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12">
                                @php
                                    $id_token = session()->get('id_Token');
                                    $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminTopics/' . $post->topic);
                                    $topic = json_decode($response);
                                    // dd($teacher)
                                @endphp
                                <input type="hidden" value="{{ $topic->id }}" name="currentTopic" readonly>
                                <input type="text" value="{{ $topic->topicName }}" disabled readonly>
                                <label for="code">Current Topic </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12">
                                <h>Select New Topic</h>
                                <select name="topic" id="topic" class="select2 browser-default">
                                    <option value="">-- </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12">
                                <button class="btn border-round col s12">Update Post</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        jQuery(document).ready(function() {
            // $('select').material_select();
            jQuery('select[name="classList"]').on('change', function() {
                // console.log("Ready");
                var classID = jQuery(this).val();
                // console.log("Class ID - " + classID);
                if (classID) {
                    jQuery.ajax({
                        url: '/posts/class2module/' + classID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            // console.log(data);
                            // console.log(data[0].id);
                            // console.log(data[0].moduleName);
                            jQuery('select[name="module"]').empty();
                            $("#module").append('<option> --Select Module-- </option>');
                            jQuery.each(data, function(id, moduleName) {
                                // console.log("Data Id - " + data[id].id);
                                // console.log("Data Module - "+ data[id].moduleName);
                                $("#module").append('<option value="' + data[id].id +
                                    '">' + data[id].moduleName + '</option>');
                                $("#module").formSelect();
                            });
                        }
                    });
                } else {
                    $('select[name="module"]').empty();
                }
            });
        });
    </script>

    <script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery('select[name="module"]').on('change', function() {
                // console.log("Ready Module 2 Topic");
                var moduleID = jQuery(this).val();
                // console.log("Module ID - " + moduleID);
                if (moduleID) {
                    jQuery.ajax({
                        url: '/posts/module2topic/' + moduleID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            // console.log(data);
                            // console.log(data[0].id);
                            // console.log(data[0].moduleName);
                            jQuery('select[name="topic"]').empty();
                            $("#topic").append('<option> --Select Topic-- </option>');
                            jQuery.each(data, function(id, moduleName) {
                                // console.log("Data Id - " + data[id].id);
                                // console.log("Data Module - "+ data[id].moduleName);
                                $("#topic").append('<option value="' + data[id].id +
                                    '">' + data[id].topicName + '</option>');
                                $("#topic").formSelect();
                            });
                        }
                    });
                } else {
                    $('select[name="module"]').empty();
                }
            });
        });
    </script>
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{ asset('vendors/quill/katex.min.js') }}"></script>
    <script src="{{ asset('vendors/quill/highlight.min.js') }}"></script>
    <script src="{{ asset('vendors/quill/quill.min.js') }}"></script>
    <script src="{{ asset('vendors/select2/select2.full.min.js') }}"></script>
@endsection

{{-- page script --}}
@section('page-script')
    <script src="{{ asset('js/scripts/form-select2.js') }}"></script>

    <!-- Initialize Quill editor -->
    <script src="{{ asset('js/scripts/form-editor.js') }}"></script>
    <script>
        var quill = new Quill('#editor', {
            modules: {
                toolbar: '#toolbar'
            },
            theme: 'snow',
            placeholder: 'Enter Post Content Here...',
            bounds: '#editor-container',
            // readOnly: true,
        });

        $(document).ready(function() {
            $("#myForm").on("submit", function() {
                var hvalue = $('.ql-editor').html();
                $(this).append("<textarea name='postContent' style='display:none'>" + hvalue +
                    "</textarea>");
            });
        });
    </script>
@endsection
