{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Binary Choice Questions')

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
        @include('pages.admin.quizzes.sidebar')


        <!--/ sidebar left end -->
        <!-- content-right start -->
        <div class="content-right">
            <!-- file manager main content start -->
            <div class="app-file-area">
                <!-- File App Content Area -->
                <!-- App File Header Starts -->


                <!-- App File Content Starts -->
                <div class="app-file-content">
                    <h6 class="font-weight-700 mb-1">{{ $quizDetails->title }} (Binary Choice Questions - True/False)</h6>

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
                                                                    <th>Binary Choice Questions</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach (json_decode($responseQuestionBq) as $key => $bqQuest)
                                                                    <tr>
                                                                        <td>
                                                                            <h6>
                                                                                <u>Question {{ $key + 1 }}.</u>
                                                                            </h6>



                                                                            {!! $bqQuest->question !!}
                                                                            <div style="color: green" class="mb-1">
                                                                               Answer: 
                                                                               @if ($bqQuest->answer == "true")
                                                                                   True
                                                                               @endif 
                                                                               @if ($bqQuest->answer == "false")
                                                                               False
                                                                           @endif 
                                                                            </div>

                                                                            @if ($bqQuest->status == 'disabled')
                                                                                <span class="chip red lighten-5">
                                                                                    <span class="red-text"> Question
                                                                                        Disabled</span>
                                                                                </span>
                                                                            @endif
                                                                            @if ($bqQuest->status == 'active')
                                                                                <span class="chip green lighten-5">
                                                                                    <span class="green-text"> Question
                                                                                        Active</span>
                                                                                </span>
                                                                            @endif

                                                                            <a href="{{ route('quizzes-bqedit', ['questId' => $bqQuest->id, 'classId' => $classId, 'quizId' => $quizId]) }}"
                                                                                class=" modal-trigger mr-5">
                                                                                <i class="material-icons">edit</i> Edit
                                                                                Question
                                                                            </a>

                                                                            <a href="#{{ $bqQuest->id }}"
                                                                                class=" modal-trigger mr-5">
                                                                                <i class="material-icons">delete</i> Delete
                                                                                Question
                                                                            </a>

                                                                        </td>

                                                                        <td>
                                                                            <div class="row">
                                                                                <div class="col s12">
                                                                                    <div id="{{ $bqQuest->id }}"
                                                                                        class="modal">
                                                                                        <div class="modal-content">
                                                                                            <h6>Delete Binary Choice
                                                                                                Question</h6>
                                                                                            <p>Are you sure you want to
                                                                                                delete this question:
                                                                                                <b>{!! $bqQuest->question !!}</b>
                                                                                                from the pool?
                                                                                            </p>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <a href="#"
                                                                                                class="modal-action modal-close waves-effect waves-red btn-flat ">No,
                                                                                                Cancel</a>
                                                                                            <a href="{{ route('quizzes-bqdelete', ['questId' => $bqQuest->id, 'classId' => $classId, 'quizId' => $quizId]) }}"
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
                                                                    <th>Binary Choice Questions</th>
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
                                                action="{{ route('quizzes-storebq') }}">
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

                                                <div class="row">
                                                    <div class="col s12">
                                                        <div class="input-field col s12">
                                                            <h6>Correct Answer</h6>
                                                            <p class="mb-1">
                                                                <label>
                                                                    <input class="with-gap" value="true" name="answer" type="radio"/>
                                                                    <span>True</span>
                                                                </label>
                                                            </p>
                                                            <p class="mb-1">
                                                                <label>
                                                                    <input class="with-gap" value="false" name="answer" type="radio" />
                                                                    <span>False </span>
                                                                </label>
                                                            </p>
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

    @endsection
