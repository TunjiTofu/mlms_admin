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
                        <a href="{{ route('quizzes-view', ['quizId' => $quizId, 'classId' => $classId]) }}"
                            class="collection-item file-item-action active">
                            <div class="fonticon-wrap display-inline mr-3">
                                <i class="material-icons">pageview</i>
                            </div>
                            <span>View Question Statistics</span>
                            {{-- <span class="chip red lighten-5 float-right red-text">2</span> --}}
                        </a>
                    </div>
                    <!-- App File Left Sidebar - Drive Content Ends -->

                    <!-- App File Left Sidebar - Labels Content Starts -->
                    <span class="app-file-label">Question Categories</span>
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
