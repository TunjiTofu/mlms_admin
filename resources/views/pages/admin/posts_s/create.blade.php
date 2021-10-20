{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title')
    Make Post
@endsection

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/flag-icon/css/flag-icon.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/noUiSlider/nouislider.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/select2/select2-materialize.css') }}">

    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('vendors/quill/katex.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/quill/monokai-sublime.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/quill/quill.snow.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/quill/quill.bubble.css') }}"> --}}
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/form-select2.css') }}">
     <!-- Include Quill stylesheet -->
    <link href="https://cdn.quilljs.com/1.0.5/quill.snow.css" rel="stylesheet" />
@endsection

{{-- page content --}}
@section('content')


    <div class="section">
        <!-- Snow Editor start -->
        {{-- <section class="snow-editor">
            <div class="row">
                <div class="col s12">
                    <div class="card">
                        <div class="card-content">
                            <h4 class="card-title">Snow Editor</h4>
                            <p class="mb-1">Snow is a clean, flat toolbar theme.</p>
                            <div class="row">
                                <div class="col s12">
                                    <div id="snow-wrapper">
                                        <div id="snow-container">
                                            <div class="quill-toolbar">
                                                <span class="ql-formats">
                                                    <select class="ql-header browser-default">
                                                        <option value="1">Heading</option>
                                                        <option value="2">Subheading</option>
                                                        <option selected>Normal</option>
                                                    </select>
                                                    <select class="ql-font browser-default">
                                                        <option selected>Sailec Light</option>
                                                        <option value="sofia">Sofia Pro</option>
                                                        <option value="slabo">Slabo 27px</option>
                                                        <option value="roboto">Roboto Slab</option>
                                                        <option value="inconsolata">Inconsolata</option>
                                                        <option value="ubuntu">Ubuntu Mono</option>
                                                    </select>
                                                </span>
                                                <span class="ql-formats">
                                                    <button class="ql-bold"></button>
                                                    <button class="ql-italic"></button>
                                                    <button class="ql-underline"></button>
                                                </span>
                                                <span class="ql-formats">
                                                    <button class="ql-list" value="ordered"></button>
                                                    <button class="ql-list" value="bullet"></button>
                                                </span>
                                                <span class="ql-formats">
                                                    <button class="ql-link"></button>
                                                    <button class="ql-image"></button>
                                                    <button class="ql-video"></button>
                                                </span>
                                                <span class="ql-formats">
                                                    <button class="ql-formula"></button>
                                                    <button class="ql-code-block"></button>
                                                </span>
                                                <span class="ql-formats">
                                                    <button class="ql-clean"></button>
                                                </span>
                                            </div>
                                            <div class="editor">
                                                <h1 class="ql-align-center">Quill Rich Text Editor</h1>
                                                <p><br></p>
                                                <p>
                                                    Quill is a free, <a href="https://github.com/quilljs/quill/">open
                                                        source</a> WYSIWYG editor
                                                    built for the modern web. With its <a
                                                        href="http://quilljs.com/docs/modules/">modular
                                                        architecture</a> and expressive <a
                                                        href="http://quilljs.com/docs/api/">API</a>, it is
                                                    completely customizable to fit any need.
                                                </p>
                                                <p><br></p>
                                                <iframe class="ql-video ql-align-center"
                                                    src="https://www.youtube.com/embed/QHH3iSeDBLo?showinfo=0" width="560"
                                                    height="238">
                                                </iframe>
                                                <p><br></p>
                                                <p><br></p>
                                                <h2 class="ql-align-center">Getting Started is Easy</h2>
                                                <p><br></p>
                                                <p><br></p>
                                                <p><br></p>
                                                <p class="ql-align-center"><strong>Built with</strong></p>
                                                <p class="ql-align-center"><span class="ql-formula"
                                                        data-value="x^2 + (y - \sqrt[3]{x^2})^2 = 1"></span>
                                                </p>
                                                <p><br></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
        <!-- Snow Editor end -->



        <div class="card">
            <div class="card-content">
                <p class="caption mb-0">
                <h6>Make Post</h6>
                <form class="row" id="myForm" method="POST" action="{{ route('posts-store') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12">
                                <input id="title" type="text" name="postTitle" class="validate" required>
                                <label for="code">Post Title</label>
                            </div>
                        </div>

                        <!-- Quill Rich Text Editor -->
                        <div class="col s12">

                            <!-- Create the toolbar container -->
                            <div id="toolbar">
                                <span class="ql-formats">
                                    <button class="ql-bold"></button>
                                    <button class="ql-italic"></button>
                                    <button class="ql-underline"></button>
                                </span>

                                <span class="ql-formats">
                                    <select class="ql-header browser-default">
                                        <option value="1">Heading</option>
                                        <option value="2">Subheading</option>
                                        <option selected>Normal</option>
                                    </select>
                                    <select class="ql-font browser-default">
                                        <option selected>Sailec Light</option>
                                        <option value="sofia">Sofia Pro</option>
                                        <option value="slabo">Slabo 27px</option>
                                        <option value="roboto">Roboto Slab</option>
                                        <option value="inconsolata">Inconsolata</option>
                                        <option value="ubuntu">Ubuntu Mono</option>
                                    </select>
                                </span>
                                
                                <span class="ql-formats">
                                    <button class="ql-list" value="ordered"></button>
                                    <button class="ql-list" value="bullet"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-link"></button>
                                    <button class="ql-image"></button>
                                    <button class="ql-video"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-formula"></button>
                                    <button class="ql-code-block"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-clean"></button>
                                </span>
                            </div>

                            <!-- Create the editor container -->
                            {{-- <label for="about">About me</label> --}}
                            {{-- <textarea class="materialize-textarea"  id="editor-textarea" name="about"></textarea> --}}
                            <div id="editor">
                                {{-- <p>Hello World!</p> --}}
                            </div>

                        </div>
                        <!-- End of Quill Rich Text Editor -->
                    </div>
                    <div class="row">
                        <div class="col s12">
                            {{-- <div class="input-field col s12">
                                <input id="post" type="text" name="postContent" class="validate" required>
                                <label for="code">Post Content</label>
                            </div> --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12">
                                <select name="classList" id="classList" class="select2 browser-default">
                                    <option value="" disabled selected>Select Class</option>
                                    @foreach (json_decode($responseClasses) as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12">
                                <select name="module" id="module" class="select2 browser-default">
                                    <option value="">Select a Module </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12">
                                <select name="topic" id="topic" class="select2 browser-default">
                                    <option value="">Select a Topic for this Post </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12">
                                <select name="status" id="status" class="select2 browser-default">
                                    <option value="" disabled selected>Select Status</option>
                                    @foreach (json_decode($responseStatus) as $status)
                                        <option value="{{ $status->id }}">{{ $status->status }}</option>
                                    @endforeach
                                </select>
                                {{-- <label>Status</label> --}}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12">
                                <button class="btn border-round col s12">Create Post</button>
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
                        url: 'class2module/' + classID,
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
                        url: 'module2topic/' + moduleID,
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
    {{-- <script src="{{ asset('vendors/quill/quill.min.js') }}"></script> --}}

    <!-- Include the Quill library -->
    <script src="https://cdn.quilljs.com/1.0.5/quill.min.js"></script>
    <!-- Initialize Quill editor -->
    <script>
        var quill = new Quill('#editor', {
            modules: {
                toolbar: '#toolbar'
            },
            theme: 'snow',
        });

        $(document).ready(function(){
        $("#myForm").on("submit", function () {
            var hvalue = $('.ql-editor').html();
            $(this).append("<textarea name='postContent' style='display:none'>"+hvalue+"</textarea>");
        });
        });
    </script>

    <script src="{{ asset('vendors/select2/select2.full.min.js') }}"></script>
@endsection

{{-- page script --}}
@section('page-script')
    <script src="{{ asset('js/scripts/form-select2.js') }}"></script>
    {{-- <script src="{{ asset('js/scripts/form-editor.js') }}"></script> --}}
@endsection
