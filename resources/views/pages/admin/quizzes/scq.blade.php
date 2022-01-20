{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Single Choice Questions')

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/flag-icon/css/flag-icon.min.css') }}">

    {{-- Data Table --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/select.dataTables.min.css') }}">

    {{-- Select 2 --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/select2/select2-materialize.css') }}">

    {{-- Quill Editor --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/quill/katex.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/quill/monokai-sublime.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/quill/quill.snow.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('vendors/quill/quill.bubble.css') }}"> --}}

@endsection

{{-- page style --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/app-file-manager.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/widget-timeline.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/data-tables.css') }}">
@endsection

{{-- page content --}}
@section('content')
    <div class="section app-file-manager-wrapper">
        <!-- File Manager app overlay -->
        <div class="app-file-overlay"></div>
        <!-- /File Manager app overlay -->
        <!-- sidebar left start -->
        <div class="sidebar-left">
            <!--left sidebar of file manager start -->
            <div class="app-file-sidebar display-flex">
                <!-- App File sidebar - Left section Starts -->
                <div class="app-file-sidebar-left">
                    <!-- sidebar close icon starts -->
                    <span class="app-file-sidebar-close hide-on-med-and-up"><i class="material-icons">close</i></span>
                    <!-- sidebar close icon ends -->
                    <div class="input-field add-new-file mt-0">
                        <!-- Add File Button -->
                        <a class="add-file-btn btn btn-block waves-effect waves-light mb-10"
                            href="{{ route('resources-add') }}">
                            <i class="material-icons">add_circle_outline</i>
                            Upload Quiz
                        </a>
                    </div>
                    <div class="app-file-sidebar-content">
                        <!-- App File Left Sidebar - Drive Content Starts -->
                        {{-- @php
                            $id_token = session()->get('id_Token');
                            $responseClass = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses/' . $classId);
                            $class = json_decode($responseClass);
                        @endphp --}}
                        <span class="app-file-label" style="color: {{ $classDetails->color }}">
                            <b>CLASS:</b> <br> {{ $classDetails->name }}
                        </span>
                        <div class="collection file-manager-drive mt-3">
                            <a href="{{ route('quizzes-viewall', ['quizId' => $quizId]) }}"
                                class="collection-item file-item-action active">
                                <div class="fonticon-wrap display-inline mr-3">
                                    <i class="material-icons">folder_open</i>
                                </div>
                                <span>All Files</span>
                                <span class="chip red lighten-5 float-right red-text">2</span>
                            </a>
                        </div>
                        <!-- App File Left Sidebar - Drive Content Ends -->

                        <!-- App File Left Sidebar - Labels Content Starts -->
                        <span class="app-file-label">Labels</span>
                        <div class="collection file-manager-drive mt-3">
                            <a href="{{ route('quizzes-viewscq', ['quizId' => $quizId, 'classId' => $classId]) }}"
                                class="collection-item file-item-action">
                                <div class="fonticon-wrap display-inline mr-3">
                                    <i class="material-icons">radio_button_checked</i>
                                </div>
                                <span> Single Choice Question</span>
                            </a>

                            <hr>
                            <a href="{{ route('quizzes-viewbq', ['quizId' => $quizId, 'classId' => $classId]) }}"
                                class="collection-item file-item-action">
                                <div class="fonticon-wrap display-inline mr-3">
                                    <i class="material-icons">loop</i>
                                </div>
                                <span>Binary Question</span>
                            </a>
                            <hr>
                            <a href="{{ route('quizzes-viewtheory', ['quizId' => $quizId, 'classId' => $classId]) }}"
                                class="collection-item file-item-action">
                                <div class="fonticon-wrap display-inline mr-3">
                                    <i class="material-icons">subject</i>
                                </div>
                                <span> Theory Question</span>
                            </a>

                        </div>
                        <!-- App File Left Sidebar - Labels Content Ends -->

                        <!-- App File Left Sidebar - Storage Content Starts -->
                        {{-- <span class="app-file-label">Storage Status</span>
                        <div class="display-flex mb-1 mt-3">
                            <div class="fonticon-wrap mr-3">
                                <i class="material-icons storage-icon">sd_card</i>
                            </div>
                            <div class="file-manager-progress">
                                <small>19.5GB used of 25GB</small>
                                <div class="progress pink lighten-5 mt-0">
                                    <div class="determinate" style="width: 70%"></div>
                                </div>
                            </div>
                        </div> --}}
                        <!-- App File Left Sidebar - Storage Content Ends -->
                    </div>
                </div>
            </div>
            <!--left sidebar of file manager start -->
        </div>
        <!--/ sidebar left end -->
        <!-- content-right start -->
        <div class="content-right">
            <!-- file manager main content start -->
            <div class="app-file-area">
                <!-- File App Content Area -->
                <!-- App File Header Starts -->


                <!-- App File Content Starts -->
                <div class="app-file-content">
                    <h6 class="font-weight-700 mb-1">{{ $quizDetails->title }} (Single Choice Questions)</h6>

                    <!-- App File - Files Section Starts -->
                    {{-- <label class="app-file-label">Single Choice Questions</label> --}}
                    <div class="row app-file-files">





                        {{-- BODYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY --}}

                        <div class="row">
                            <div class="col s12">
                                {{-- <div class="row" id="main-view"> --}}
                                <div class="row">
                                    <div class="col s12">
                                        <ul class="tabs tab-demo z-depth-1">
                                            <li class="tab col m3"><a class="active" href="#test1">View
                                                    Questions</a>
                                            </li>
                                            <li class="tab col m3"><a href="#test2">Add New Questions</a></li>
                                            <li class="tab col m3"><a href="#test3">Bulk Upload</a></li>
                                        </ul>
                                    </div>
                                    <div class="col s12">
                                        <div id="test1" class="col s12">
                                            <div class="section section-data-tables">
                                                <div class="row mt-2">
                                                    <div class="col s12">
                                                        <table id="page-length-option" class="display">
                                                            <thead>
                                                                <tr>
                                                                    <th>Single Choice Qustions</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach (json_decode($responseQuestionScq) as $key => $scqQuest)
                                                                    <tr>
                                                                        <td>
                                                                            <h6>Question {{ $key + 1 }}.</h6>
                                                                            {!! $scqQuest->question !!} 
                                                                            <h6>Option A.</h6>
                                                                            {!! $scqQuest->optionA !!} 
                                                                            <h6>Option B.</h6>
                                                                            {!! $scqQuest->optionB !!} 
                                                                            <h6>Option C.</h6>
                                                                            {!! $scqQuest->optionC !!} 
                                                                            <h6>Option D.</h6>
                                                                            {!! $scqQuest->optionD !!} 

                                                                            {{-- <b>{{ $quiz->title }}</b><br>
                                                                        @php
                                                                            $id_token = session()->get('id_Token');
                                                                            $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses/' . $quiz->class);
                                                                            $className = json_decode($response);
                                                                            // dd($className)
                                                                        @endphp
                                                                        <b>Class: </b> <br>{{ ucwords($className->name) }} --}}
                                                                        </td>

                                                                        <td>
                                                                            <a href="#e{{ $scqQuest->id }}"
                                                                                class=" modal-trigger mr-5">
                                                                                <i class="material-icons">edit</i>
                                                                            </a>
                                                                            {{-- <a href="{{ route('quizzes-view', ['quizId' => $scqQuest->id,'classId' => $quiz->class], ) }}" --}}
                                                                            <a href="#"
                                                                                class="mr-5">
                                                                                <i class="material-icons">remove_red_eye</i>
                                                                            </a>
                                                                            <a href="#{{ $scqQuest->id }}"
                                                                                class=" modal-trigger mr-5">
                                                                                <i class="material-icons">delete</i>
                                                                            </a>
                                                                            
                                                                            <div class="row">
                                                                                <div class="col s12">
                                                                                    <div id="{{ $scqQuest->id }}" class="modal">
                                                                                        <div class="modal-content">
                                                                                            <h6>Delete Single Choice Question</h6>
                                                                                            <p>Are you sure you want to delete this question:
                                                                                                <b>{!! $scqQuest->question !!}</b> from the pool?
                                                                                            </p>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <a href="#"
                                                                                                class="modal-action modal-close waves-effect waves-red btn-flat ">No,
                                                                                                Cancel</a>
                                                                                            <a href="{{ route('quizzes-delete', ['id' => $scqQuest->id]) }}"
                                                                                                class="modal-action modal-close waves-effect waves-green btn-flat ">Yes,
                                                                                                Delete</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th>Quiz Title</th>
                                                                    <th></th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="test2" class="col s12">
                                            <p class="mt-2 mb-2">
                                            <form class="row mt-1" id="myForm" method="POST"
                                                action="{{ route('quizzes-storescq') }}">
                                                {{ csrf_field() }}
                                                <div class="row mb-2">
                                                    <div class="col s12">
                                                        <input type="text" name="quizId" value="{{ $quizId }}"
                                                            readonly>
                                                        <input type="text" name="classId" value="{{ $classId }}"
                                                            readonly>
                                                        <!-- Quill Rich Text Editor -->
                                                        <div class="snow-editor col s12" id="editor-container">
                                                            <div id="snow-wrapper">
                                                                <div id="snow-container">
                                                                    <h6>Question</h6>
                                                                    <!-- Create the toolbar container -->
                                                                    <div id="toolbar">
                                                                        <span class="ql-formats">
                                                                            <button class="ql-bold"
                                                                                title="Bold"></button>
                                                                            <button class="ql-italic"
                                                                                title="Italics"></button>
                                                                            <button class="ql-strike"
                                                                                title="Strikethrough"></button>
                                                                            <button class="ql-underline"
                                                                                title="Underline"></button>
                                                                            <button class="ql-script" value="sub"
                                                                                title="Subscript"></button>
                                                                            <button class="ql-script" value="super"
                                                                                title="Superscript"></button>
                                                                        </span>

                                                                        <span class="ql-formats">
                                                                            {{-- <select class="ql-header browser-default"
                                                                                title="Heading Size">
                                                                                <option selected value="false">Heading
                                                                                </option>
                                                                                <option value="1">Heading 1</option>
                                                                                <option value="2">Heading 2</option>
                                                                                <option value="3">Heading 3</option>
                                                                                <option value="4">Heading 4</option>
                                                                                <option value="5">Heading 5</option>
                                                                                <option value="6">Heading 6</option>
                                                                            </select> --}}

                                                                            {{-- <span class="ql-header browser-default">
                                                                                <select class="ql-size browser-default"
                                                                                    title="Font Sizes">
                                                                                    <option selected value="false">Text
                                                                                        Sizes
                                                                                    </option>
                                                                                    <option value="small">small</option>
                                                                                    <option value="large">large</option>
                                                                                    <option value="huge">huge</option>
                                                                                </select>
                                                                            </span> --}}

                                                                            {{-- <select class="ql-font browser-default"
                                                                                title="Font Styles">
                                                                                <option selected>Sailec Light</option>
                                                                                <option value="comic sans">Comic Sans
                                                                                </option>
                                                                                <option value="sofia">Sofia Pro</option>
                                                                                <option value="slabo">Slabo 27px</option>
                                                                                <option value="roboto">Roboto Slab</option>
                                                                                <option value="inconsolata">Inconsolata
                                                                                </option>
                                                                                <option value="ubuntu">Ubuntu Mono</option>
                                                                            </select> --}}

                                                                        </span>
                                                                        <span class="ql-formats">
                                                                            <select class="ql-color browser-default"
                                                                                title="Text Color">
                                                                            </select>
                                                                            <select class="ql-background browser-default"
                                                                                title="Background Color">
                                                                            </select>
                                                                        </span>

                                                                        <span class="ql-formats">
                                                                            <button class="ql-list" value="ordered"
                                                                                title="Bullets"></button>
                                                                            <button class="ql-list" value="bullet"
                                                                                title="Number"></button>
                                                                            <button class="ql-indent" value="+1"
                                                                                title="Indent Inward"></button>
                                                                            <button class="ql-indent" value="-1"
                                                                                title="Indent Outward"></button>
                                                                            <select class="ql-align browser-default"
                                                                                title="Align Text">
                                                                            </select>
                                                                        </span>
                                                                        <span class="ql-formats">
                                                                            {{-- <button class="ql-link"
                                                                                title="Embed Link"></button> --}}
                                                                            <button class="ql-image"
                                                                                title="Embed Image"></button>
                                                                            {{-- <button class="ql-video"
                                                                                title="Embed Video"></button> --}}
                                                                        </span>
                                                                        <span class="ql-formats">
                                                                            <button class="ql-formula"
                                                                                title="Insert Formular"></button>
                                                                            <button class="ql-code-block"
                                                                                title="Insert Code Block"></button>
                                                                        </span>
                                                                        <span class="ql-formats">
                                                                            <button class="ql-clean"
                                                                                title="Remove Formatting Button"></button>
                                                                        </span>
                                                                    </div>

                                                                    <div id="editor">

                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!-- End of Quill Rich Text Editor -->
                                                        <textarea name="question" style="display:none"
                                                            id="hiddenAreaContentQuestion"></textarea>
                                                    </div>
                                                </div>

                                                <div class="row mb-2">
                                                    <div class="col s12">
                                                        <!-- Quill Rich Text Editor -->
                                                        <div class="snow-editor col s12" id="editor-container">
                                                            <div id="snow-wrapper">
                                                                <div id="snow-container">
                                                                    <h6>Option A</h6>
                                                                    <!-- Create the toolbar container -->
                                                                    <div id="toolbarA">
                                                                        <span class="ql-formats">
                                                                            <button class="ql-bold"
                                                                                title="Bold"></button>
                                                                            <button class="ql-italic"
                                                                                title="Italics"></button>
                                                                            <button class="ql-strike"
                                                                                title="Strikethrough"></button>
                                                                            <button class="ql-underline"
                                                                                title="Underline"></button>
                                                                            <button class="ql-script" value="sub"
                                                                                title="Subscript"></button>
                                                                            <button class="ql-script" value="super"
                                                                                title="Superscript"></button>
                                                                        </span>

                                                                        <span class="ql-formats">
                                                                            {{-- <select class="ql-header browser-default"
                                                                                title="Heading Size">
                                                                                <option selected value="false">Heading
                                                                                </option>
                                                                                <option value="1">Heading 1</option>
                                                                                <option value="2">Heading 2</option>
                                                                                <option value="3">Heading 3</option>
                                                                                <option value="4">Heading 4</option>
                                                                                <option value="5">Heading 5</option>
                                                                                <option value="6">Heading 6</option>
                                                                            </select> --}}

                                                                            {{-- <span class="ql-header browser-default">
                                                                                <select class="ql-size browser-default"
                                                                                    title="Font Sizes">
                                                                                    <option selected value="false">Text
                                                                                        Sizes
                                                                                    </option>
                                                                                    <option value="small">small</option>
                                                                                    <option value="large">large</option>
                                                                                    <option value="huge">huge</option>
                                                                                </select>
                                                                            </span> --}}

                                                                            {{-- <select class="ql-font browser-default"
                                                                                title="Font Styles">
                                                                                <option selected>Sailec Light</option>
                                                                                <option value="comic sans">Comic Sans
                                                                                </option>
                                                                                <option value="sofia">Sofia Pro</option>
                                                                                <option value="slabo">Slabo 27px</option>
                                                                                <option value="roboto">Roboto Slab</option>
                                                                                <option value="inconsolata">Inconsolata
                                                                                </option>
                                                                                <option value="ubuntu">Ubuntu Mono</option>
                                                                            </select> --}}

                                                                        </span>
                                                                        <span class="ql-formats">
                                                                            <select class="ql-color browser-default"
                                                                                title="Text Color">
                                                                            </select>
                                                                            <select class="ql-background browser-default"
                                                                                title="Background Color">
                                                                            </select>
                                                                        </span>

                                                                        <span class="ql-formats">
                                                                            <button class="ql-list" value="ordered"
                                                                                title="Bullets"></button>
                                                                            <button class="ql-list" value="bullet"
                                                                                title="Number"></button>
                                                                            <button class="ql-indent" value="+1"
                                                                                title="Indent Inward"></button>
                                                                            <button class="ql-indent" value="-1"
                                                                                title="Indent Outward"></button>
                                                                            <select class="ql-align browser-default"
                                                                                title="Align Text">
                                                                            </select>
                                                                        </span>
                                                                        <span class="ql-formats">
                                                                            {{-- <button class="ql-link"
                                                                                title="Embed Link"></button> --}}
                                                                            <button class="ql-image"
                                                                                title="Embed Image"></button>
                                                                            {{-- <button class="ql-video"
                                                                                title="Embed Video"></button> --}}
                                                                        </span>
                                                                        <span class="ql-formats">
                                                                            <button class="ql-formula"
                                                                                title="Insert Formular"></button>
                                                                            <button class="ql-code-block"
                                                                                title="Insert Code Block"></button>
                                                                        </span>
                                                                        <span class="ql-formats">
                                                                            <button class="ql-clean"
                                                                                title="Remove Formatting Button"></button>
                                                                        </span>
                                                                    </div>

                                                                    <div id="editor2">

                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!-- End of Quill Rich Text Editor -->
                                                        <textarea name="optionA" style="display:none"
                                                            id="hiddenAreaContentOptionA"></textarea>
                                                    </div>
                                                </div>

                                                <div class="row mb-2">
                                                    <div class="col s12">
                                                        <!-- Quill Rich Text Editor -->
                                                        <div class="snow-editor col s12" id="editor-container">
                                                            <div id="snow-wrapper">
                                                                <div id="snow-container">
                                                                    <h6>Option B</h6>
                                                                    <!-- Create the toolbar container -->
                                                                    <div id="toolbarB">
                                                                        <span class="ql-formats">
                                                                            <button class="ql-bold"
                                                                                title="Bold"></button>
                                                                            <button class="ql-italic"
                                                                                title="Italics"></button>
                                                                            <button class="ql-strike"
                                                                                title="Strikethrough"></button>
                                                                            <button class="ql-underline"
                                                                                title="Underline"></button>
                                                                            <button class="ql-script" value="sub"
                                                                                title="Subscript"></button>
                                                                            <button class="ql-script" value="super"
                                                                                title="Superscript"></button>
                                                                        </span>

                                                                        <span class="ql-formats">
                                                                            {{-- <select class="ql-header browser-default"
                                                                                title="Heading Size">
                                                                                <option selected value="false">Heading
                                                                                </option>
                                                                                <option value="1">Heading 1</option>
                                                                                <option value="2">Heading 2</option>
                                                                                <option value="3">Heading 3</option>
                                                                                <option value="4">Heading 4</option>
                                                                                <option value="5">Heading 5</option>
                                                                                <option value="6">Heading 6</option>
                                                                            </select> --}}

                                                                            {{-- <span class="ql-header browser-default">
                                                                                <select class="ql-size browser-default"
                                                                                    title="Font Sizes">
                                                                                    <option selected value="false">Text
                                                                                        Sizes
                                                                                    </option>
                                                                                    <option value="small">small</option>
                                                                                    <option value="large">large</option>
                                                                                    <option value="huge">huge</option>
                                                                                </select>
                                                                            </span> --}}

                                                                            {{-- <select class="ql-font browser-default"
                                                                                title="Font Styles">
                                                                                <option selected>Sailec Light</option>
                                                                                <option value="comic sans">Comic Sans
                                                                                </option>
                                                                                <option value="sofia">Sofia Pro</option>
                                                                                <option value="slabo">Slabo 27px</option>
                                                                                <option value="roboto">Roboto Slab</option>
                                                                                <option value="inconsolata">Inconsolata
                                                                                </option>
                                                                                <option value="ubuntu">Ubuntu Mono</option>
                                                                            </select> --}}

                                                                        </span>
                                                                        <span class="ql-formats">
                                                                            <select class="ql-color browser-default"
                                                                                title="Text Color">
                                                                            </select>
                                                                            <select class="ql-background browser-default"
                                                                                title="Background Color">
                                                                            </select>
                                                                        </span>

                                                                        <span class="ql-formats">
                                                                            <button class="ql-list" value="ordered"
                                                                                title="Bullets"></button>
                                                                            <button class="ql-list" value="bullet"
                                                                                title="Number"></button>
                                                                            <button class="ql-indent" value="+1"
                                                                                title="Indent Inward"></button>
                                                                            <button class="ql-indent" value="-1"
                                                                                title="Indent Outward"></button>
                                                                            <select class="ql-align browser-default"
                                                                                title="Align Text">
                                                                            </select>
                                                                        </span>
                                                                        <span class="ql-formats">
                                                                            {{-- <button class="ql-link"
                                                                                title="Embed Link"></button> --}}
                                                                            <button class="ql-image"
                                                                                title="Embed Image"></button>
                                                                            {{-- <button class="ql-video"
                                                                                title="Embed Video"></button> --}}
                                                                        </span>
                                                                        <span class="ql-formats">
                                                                            <button class="ql-formula"
                                                                                title="Insert Formular"></button>
                                                                            <button class="ql-code-block"
                                                                                title="Insert Code Block"></button>
                                                                        </span>
                                                                        <span class="ql-formats">
                                                                            <button class="ql-clean"
                                                                                title="Remove Formatting Button"></button>
                                                                        </span>
                                                                    </div>

                                                                    <div id="editor3">

                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!-- End of Quill Rich Text Editor -->
                                                        <textarea name="optionB" style="display:none"
                                                            id="hiddenAreaContentOptionB"></textarea>
                                                    </div>
                                                </div>

                                                <div class="row mb-2">
                                                    <div class="col s12">
                                                        <!-- Quill Rich Text Editor -->
                                                        <div class="snow-editor col s12" id="editor-container">
                                                            <div id="snow-wrapper">
                                                                <div id="snow-container">
                                                                    <h6>Option C</h6>
                                                                    <!-- Create the toolbar container -->
                                                                    <div id="toolbarC">
                                                                        <span class="ql-formats">
                                                                            <button class="ql-bold"
                                                                                title="Bold"></button>
                                                                            <button class="ql-italic"
                                                                                title="Italics"></button>
                                                                            <button class="ql-strike"
                                                                                title="Strikethrough"></button>
                                                                            <button class="ql-underline"
                                                                                title="Underline"></button>
                                                                            <button class="ql-script" value="sub"
                                                                                title="Subscript"></button>
                                                                            <button class="ql-script" value="super"
                                                                                title="Superscript"></button>
                                                                        </span>

                                                                        <span class="ql-formats">
                                                                            {{-- <select class="ql-header browser-default"
                                                                                title="Heading Size">
                                                                                <option selected value="false">Heading
                                                                                </option>
                                                                                <option value="1">Heading 1</option>
                                                                                <option value="2">Heading 2</option>
                                                                                <option value="3">Heading 3</option>
                                                                                <option value="4">Heading 4</option>
                                                                                <option value="5">Heading 5</option>
                                                                                <option value="6">Heading 6</option>
                                                                            </select> --}}

                                                                            {{-- <span class="ql-header browser-default">
                                                                                <select class="ql-size browser-default"
                                                                                    title="Font Sizes">
                                                                                    <option selected value="false">Text
                                                                                        Sizes
                                                                                    </option>
                                                                                    <option value="small">small</option>
                                                                                    <option value="large">large</option>
                                                                                    <option value="huge">huge</option>
                                                                                </select>
                                                                            </span> --}}

                                                                            {{-- <select class="ql-font browser-default"
                                                                                title="Font Styles">
                                                                                <option selected>Sailec Light</option>
                                                                                <option value="comic sans">Comic Sans
                                                                                </option>
                                                                                <option value="sofia">Sofia Pro</option>
                                                                                <option value="slabo">Slabo 27px</option>
                                                                                <option value="roboto">Roboto Slab</option>
                                                                                <option value="inconsolata">Inconsolata
                                                                                </option>
                                                                                <option value="ubuntu">Ubuntu Mono</option>
                                                                            </select> --}}

                                                                        </span>
                                                                        <span class="ql-formats">
                                                                            <select class="ql-color browser-default"
                                                                                title="Text Color">
                                                                            </select>
                                                                            <select class="ql-background browser-default"
                                                                                title="Background Color">
                                                                            </select>
                                                                        </span>

                                                                        <span class="ql-formats">
                                                                            <button class="ql-list" value="ordered"
                                                                                title="Bullets"></button>
                                                                            <button class="ql-list" value="bullet"
                                                                                title="Number"></button>
                                                                            <button class="ql-indent" value="+1"
                                                                                title="Indent Inward"></button>
                                                                            <button class="ql-indent" value="-1"
                                                                                title="Indent Outward"></button>
                                                                            <select class="ql-align browser-default"
                                                                                title="Align Text">
                                                                            </select>
                                                                        </span>
                                                                        <span class="ql-formats">
                                                                            {{-- <button class="ql-link"
                                                                                title="Embed Link"></button> --}}
                                                                            <button class="ql-image"
                                                                                title="Embed Image"></button>
                                                                            {{-- <button class="ql-video"
                                                                                title="Embed Video"></button> --}}
                                                                        </span>
                                                                        <span class="ql-formats">
                                                                            <button class="ql-formula"
                                                                                title="Insert Formular"></button>
                                                                            <button class="ql-code-block"
                                                                                title="Insert Code Block"></button>
                                                                        </span>
                                                                        <span class="ql-formats">
                                                                            <button class="ql-clean"
                                                                                title="Remove Formatting Button"></button>
                                                                        </span>
                                                                    </div>

                                                                    <div id="editor4">

                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!-- End of Quill Rich Text Editor -->
                                                        <textarea name="optionC" style="display:none"
                                                            id="hiddenAreaContentOptionC"></textarea>
                                                    </div>
                                                </div>

                                                <div class="row mb-2">
                                                    <div class="col s12">
                                                        <!-- Quill Rich Text Editor -->
                                                        <div class="snow-editor col s12" id="editor-container">
                                                            <div id="snow-wrapper">
                                                                <div id="snow-container">
                                                                    <h6>Option D</h6>
                                                                    <!-- Create the toolbar container -->
                                                                    <div id="toolbarD">
                                                                        <span class="ql-formats">
                                                                            <button class="ql-bold"
                                                                                title="Bold"></button>
                                                                            <button class="ql-italic"
                                                                                title="Italics"></button>
                                                                            <button class="ql-strike"
                                                                                title="Strikethrough"></button>
                                                                            <button class="ql-underline"
                                                                                title="Underline"></button>
                                                                            <button class="ql-script" value="sub"
                                                                                title="Subscript"></button>
                                                                            <button class="ql-script" value="super"
                                                                                title="Superscript"></button>
                                                                        </span>

                                                                        <span class="ql-formats">
                                                                            {{-- <select class="ql-header browser-default"
                                                                                title="Heading Size">
                                                                                <option selected value="false">Heading
                                                                                </option>
                                                                                <option value="1">Heading 1</option>
                                                                                <option value="2">Heading 2</option>
                                                                                <option value="3">Heading 3</option>
                                                                                <option value="4">Heading 4</option>
                                                                                <option value="5">Heading 5</option>
                                                                                <option value="6">Heading 6</option>
                                                                            </select> --}}

                                                                            {{-- <span class="ql-header browser-default">
                                                                                <select class="ql-size browser-default"
                                                                                    title="Font Sizes">
                                                                                    <option selected value="false">Text
                                                                                        Sizes
                                                                                    </option>
                                                                                    <option value="small">small</option>
                                                                                    <option value="large">large</option>
                                                                                    <option value="huge">huge</option>
                                                                                </select>
                                                                            </span> --}}

                                                                            {{-- <select class="ql-font browser-default"
                                                                                title="Font Styles">
                                                                                <option selected>Sailec Light</option>
                                                                                <option value="comic sans">Comic Sans
                                                                                </option>
                                                                                <option value="sofia">Sofia Pro</option>
                                                                                <option value="slabo">Slabo 27px</option>
                                                                                <option value="roboto">Roboto Slab</option>
                                                                                <option value="inconsolata">Inconsolata
                                                                                </option>
                                                                                <option value="ubuntu">Ubuntu Mono</option>
                                                                            </select> --}}

                                                                        </span>
                                                                        <span class="ql-formats">
                                                                            <select class="ql-color browser-default"
                                                                                title="Text Color">
                                                                            </select>
                                                                            <select class="ql-background browser-default"
                                                                                title="Background Color">
                                                                            </select>
                                                                        </span>

                                                                        <span class="ql-formats">
                                                                            <button class="ql-list" value="ordered"
                                                                                title="Bullets"></button>
                                                                            <button class="ql-list" value="bullet"
                                                                                title="Number"></button>
                                                                            <button class="ql-indent" value="+1"
                                                                                title="Indent Inward"></button>
                                                                            <button class="ql-indent" value="-1"
                                                                                title="Indent Outward"></button>
                                                                            <select class="ql-align browser-default"
                                                                                title="Align Text">
                                                                            </select>
                                                                        </span>
                                                                        <span class="ql-formats">
                                                                            {{-- <button class="ql-link"
                                                                                title="Embed Link"></button> --}}
                                                                            <button class="ql-image"
                                                                                title="Embed Image"></button>
                                                                            {{-- <button class="ql-video"
                                                                                title="Embed Video"></button> --}}
                                                                        </span>
                                                                        <span class="ql-formats">
                                                                            <button class="ql-formula"
                                                                                title="Insert Formular"></button>
                                                                            <button class="ql-code-block"
                                                                                title="Insert Code Block"></button>
                                                                        </span>
                                                                        <span class="ql-formats">
                                                                            <button class="ql-clean"
                                                                                title="Remove Formatting Button"></button>
                                                                        </span>
                                                                    </div>

                                                                    <div id="editor5">

                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!-- End of Quill Rich Text Editor -->
                                                        <textarea name="optionD" style="display:none"
                                                            id="hiddenAreaContentOptionD"></textarea>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col s12">
                                                        <div class="input-field col s12">
                                                            <h6>Correct Answer</h6>
                                                            <select name="answer" id="answer"
                                                                class="select2 browser-default">
                                                                <option value="" disabled selected>Select Correct Option
                                                                </option>
                                                                <option value="A">Option A</option>
                                                                <option value="B">Option B</option>
                                                                <option value="C">Option C</option>
                                                                <option value="D">Option D</option>
                                                            </select>
                                                            {{-- <label>Status</label> --}}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col s12">
                                                        <div class="input-field col s12">
                                                            <h>Status</h>
                                                            <select name="status" id="status"
                                                                class="select2 browser-default">
                                                                <option value="" disabled selected>Select Status</option>
                                                                @foreach (json_decode($responseStatus) as $status)
                                                                    <option value="{{ $status->id }}">
                                                                        {{ $status->status }}</option>
                                                                @endforeach
                                                            </select>
                                                            {{-- <label>Status</label> --}}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col s12">
                                                        <div class="input-field col s12">
                                                            <button class="btn border-round col s12">Add Question</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>


                                            </p>
                                        </div>
                                        <div id="test3" class="col s12">
                                            <p class="mt-2 mb-2">
                                                Coming Soon!
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>






                        <!-- App File - Files Section Ends -->
                    </div>
                </div>

                <!-- file manager main content end  -->
            </div>

        </div>
    @endsection

    {{-- vendor scripts --}}
    @section('vendor-script')
        <script src="{{ asset('vendors/quill/katex.min.js') }}"></script>
        <script src="{{ asset('vendors/quill/highlight.min.js') }}"></script>
        <script src="{{ asset('vendors/quill/quill.min.js') }}"></script>
        <script src="{{ asset('vendors/select2/select2.full.min.js') }}"></script>

        {{-- Data Table --}}
        <script src="{{ asset('vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('vendors/data-tables/js/dataTables.select.min.js') }}"></script>
    @endsection

    {{-- page script --}}
    @section('page-script')
        {{-- <script src="{{ asset('js/scripts/app-file-manager.js') }}"></script> --}}
        <script src="{{ asset('js/scripts/advance-ui-modals.js') }}"></script>
        <script src="{{ asset('js/scripts/form-select2.js') }}"></script>
        <script src="{{ asset('js/scripts/ui-alerts.js') }}"></script>
        <script src="{{ asset('js/scripts/data-tables.js') }}"></script>


        <!-- Initialize Quill editor -->
        <script src="{{ asset('js/scripts/form-editor.js') }}"></script>

        <!-- Initialize Quill editor for Post Content -->
        <script>
            var quill = new Quill('#editor', {
                modules: {
                    toolbar: '#toolbar'
                },
                theme: 'snow',
                placeholder: 'Enter Question Here...',
                bounds: '#editor-container'
            });

            $("#myForm").on("submit", function() {
                $("#hiddenAreaContentQuestion").val($("#editor .ql-editor").html());
            });
        </script>

        <script>
            var quill = new Quill('#editor2', {
                modules: {
                    toolbar: '#toolbarA'
                },
                theme: 'snow',
                placeholder: 'Enter Option A Here...',
                bounds: '#editor-container'
            });

            $("#myForm").on("submit", function() {
                $("#hiddenAreaContentOptionA").val($("#editor2 .ql-editor").html());
            });
        </script>

        <script>
            var quill = new Quill('#editor3', {
                modules: {
                    toolbar: '#toolbarB'
                },
                theme: 'snow',
                placeholder: 'Enter Option B Here...',
                bounds: '#editor-container'
            });

            $("#myForm").on("submit", function() {
                $("#hiddenAreaContentOptionB").val($("#editor3 .ql-editor").html());
            });
        </script>

        <script>
            var quill = new Quill('#editor4', {
                modules: {
                    toolbar: '#toolbarC'
                },
                theme: 'snow',
                placeholder: 'Enter Option C Here...',
                bounds: '#editor-container'
            });

            $("#myForm").on("submit", function() {
                $("#hiddenAreaContentOptionC").val($("#editor4 .ql-editor").html());
            });
        </script>

        <script>
            var quill = new Quill('#editor5', {
                modules: {
                    toolbar: '#toolbarD'
                },
                theme: 'snow',
                placeholder: 'Enter Option D Here...',
                bounds: '#editor-container'
            });

            $("#myForm").on("submit", function() {
                $("#hiddenAreaContentOptionD").val($("#editor5 .ql-editor").html());
            });
        </script>

    @endsection
