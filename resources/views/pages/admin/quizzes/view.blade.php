{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'View Quiz Details')

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/flag-icon/css/flag-icon.min.css') }}">
@endsection

{{-- page style --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/app-file-manager.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/widget-timeline.css') }}">
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
                    <h5 class="font-weight-700 mb-3">{{ $quizDetails->title }}</h5>
                    <h6>Total Questions in Database</h6>
                    <!-- App File - Files Section Starts -->
                    <div class="row app-file-files">
                        <div class="row">
                            <div class="col s12 m6 l3 card-width">
                                <div class="card border-radius-6">
                                    <div class="card-content center-align">
                                        <i class="material-icons green-text small-ico-bg mb-5">radio_button_checked</i>
                                        <h4 class="m-0"><b>{{ $scqCount->scqSize }}</b></h4>
                                        <p class="red-text">Single Choice Questions</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col s12 m6 l3 card-width">
                                <div class="card border-radius-6">
                                    <div class="card-content center-align">
                                        <i class="material-icons green-text small-ico-bg mb-5">loop</i>
                                        <h4 class="m-0"><b>{{ $bqCount->bqSize }}</b></h4>
                                        <p class="red-text">Binary Choice Questions</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col s12 m6 l3 card-width">
                                <div class="card border-radius-6">
                                    <div class="card-content center-align">
                                        <i class="material-icons green-text small-ico-bg mb-5">subject</i>
                                        <h4 class="m-0"><b>{{ $theoryCount->theorySize }}</b></h4>
                                        <p class="red-text">Theory Questions</p>
                                    </div>
                                </div>
                            </div>
                        </div>




                        {{-- BODYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY --}}






                        <!-- App File - Files Section Ends -->
                    </div>
                </div>

                <!-- file manager main content end  -->
            </div>

        </div>
    @endsection

    {{-- vendor scripts --}}
    @section('vendor-script')
    @endsection

    {{-- page script --}}
    @section('page-script')
        <script src="{{ asset('js/scripts/app-file-manager.js') }}"></script>
        <script src="{{ asset('js/scripts/advance-ui-modals.js') }}"></script>
    @endsection
