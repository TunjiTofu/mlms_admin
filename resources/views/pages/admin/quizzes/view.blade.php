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
                    <h6 class="font-weight-700 mb-3">{{ $quizDetails->title }}</h6>

                    <!-- App File - Files Section Starts -->
                    <label class="app-file-label">Files</label>
                    <div class="row app-file-files">





                        {{-- BODYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY --}}






                        <!-- App File - Files Section Ends -->
                    </div>
                </div>

                <!-- file manager main content end  -->
            </div>
            <!-- content-right end -->
            <!-- App File sidebar - Right section Starts -->
            {{-- <div class="app-file-sidebar-info">
            <div class="card box-shadow-none m-0 pb-1">
                <div class="card-header display-flex justify-content-between align-items-center">
                    <h6 class="m-0">Document.pdf</h6>
                    <div class="app-file-action-icons display-flex align-items-center">
                        <i class="material-icons mr-10">delete</i>
                        <i class="material-icons close-icon">close</i>
                    </div>
                </div>
                <div class="card-content">
                    <ul class="tabs tabs-fixed-width mb-1">
                        <li class="tab mr-1 pr-1">
                            <a class="active display-flex align-items-center" id="details-tab" href="#details">
                                <i class="material-icons mr-1">content_paste</i>
                                <span>Details</span>
                            </a>
                        </li>
                        <li class="tab">
                            <a class="display-flex align-items-center" id="activity-tab" href="#file-activity">
                                <i class="material-icons mr-1">timeline</i>
                                <span>Activity</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="details-tab active" id="details">
                            <div class="display-flex align-items-center flex-column pb-2 pt-4">
                                <img src="{{ asset('images/icon/pdf.png') }}" alt="PDF" height="42" width="35"
                                    class="mt-5 mb-5">
                                <p class="mt-4">15.3mb</p>
                            </div>
                            <div class="divider mt-5 mb-5"></div>
                            <div class="pt-6">
                                <span class="app-file-label">Setting</span>
                                <div class="display-flex justify-content-between align-items-center mt-6">
                                    <p>File Sharing</p>
                                    <div class="switch">
                                        <label>
                                            <input type="checkbox" id="customSwitchGlow1">
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="display-flex justify-content-between align-items-center mt-6">
                                    <p>Synchronization</p>
                                    <div class="switch">
                                        <label>
                                            <input type="checkbox" id="customSwitchGlow2" checked>
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="display-flex justify-content-between align-items-center mt-6 mb-8">
                                    <p>Backup</p>
                                    <div class="switch">
                                        <label>
                                            <input type="checkbox" id="customSwitchGlow3">
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </div>
                                <span class="app-file-label">Info</span>
                                <div class="display-flex justify-content-between align-items-center mt-6">
                                    <p>Type</p>
                                    <p class="font-weight-700">PDF</p>
                                </div>
                                <div class="display-flex justify-content-between align-items-center mt-6">
                                    <p>Size</p>
                                    <p class="font-weight-700">15.6mb</p>
                                </div>
                                <div class="display-flex justify-content-between align-items-center mt-6">
                                    <p>Location</p>
                                    <p class="font-weight-700">Files > Documents</p>
                                </div>
                                <div class="display-flex justify-content-between align-items-center mt-6">
                                    <p>Owner</p>
                                    <p class="font-weight-700">Elnora Reese</p>
                                </div>
                                <div class="display-flex justify-content-between align-items-center mt-6">
                                    <p>Modified</p>
                                    <p class="font-weight-700">September 4 2019</p>
                                </div>
                                <div class="display-flex justify-content-between align-items-center mt-6">
                                    <p>Opened</p>
                                    <p class="font-weight-700">July 8, 2019</p>
                                </div>
                                <div class="display-flex justify-content-between align-items-center mt-6">
                                    <p>Created</p>
                                    <p class="font-weight-700">July 1, 2019</p>
                                </div>
                            </div>
                        </div>
                        <div class="activity-tab" id="file-activity">
                            <ul class="widget-timeline mb-0">
                                <li class="timeline-items timeline-icon-green active">
                                    <div class="timeline-time">Today</div>
                                    <h6 class="timeline-title">You added an item to</h6>
                                    <p class="timeline-text">You added an item</p>
                                    <div class="timeline-content">
                                        <img src="{{ asset('images/icon/psd.png') }}" alt="PSD" height="30" width="25"
                                            class="mr-1">Mockup.psd
                                    </div>
                                </li>
                                <li class="timeline-items timeline-icon-cyan active">
                                    <div class="timeline-time">10 min ago</div>
                                    <h6 class="timeline-title">You shared 2 times</h6>
                                    <p class="timeline-text">Emily Bennett edited an item</p>
                                    <div class="timeline-content">
                                        <img src="{{ asset('images/icon/sketch.png') }}" alt="Sketch" height="30"
                                            width="25" class="mr-1">Template_Design.sketch
                                    </div>
                                </li>
                                <li class="timeline-items timeline-icon-red active">
                                    <div class="timeline-time">Mon 10:20 PM</div>
                                    <h6 class="timeline-title">You edited an item</h6>
                                    <p class="timeline-text">You edited an item</p>
                                    <div class="timeline-content">
                                        <img src="{{ asset('images/icon/pdf.png') }}" alt="document" height="30"
                                            width="25" class="mr-1">Information.doc
                                    </div>
                                </li>
                                <li class="timeline-items timeline-icon-indigo active">
                                    <div class="timeline-time">Jul 13 2019</div>
                                    <h6 class="timeline-title">You edited an item</h6>
                                    <p class="timeline-text">John Keller edited an item</p>
                                    <div class="timeline-content">
                                        <img src="{{ asset('images/icon/pdf.png') }}" alt="document" height="30"
                                            width="25" class="mr-1">Documentation.doc
                                    </div>
                                </li>
                                <li class="timeline-items timeline-icon-orange">
                                    <div class="timeline-time">Apr 18 2019</div>
                                    <h6 class="timeline-title">You added an item to</h6>
                                    <p class="timeline-text">You edited an item</p>
                                    <div class="timeline-content">
                                        <img src="{{ asset('images/icon/pdf.png') }}" alt="document" height="30"
                                            width="25" class="mr-1">Resume.pdf
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
            <!-- App File sidebar - Right section Ends -->
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
