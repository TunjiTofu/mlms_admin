{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Edit User')

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/select2/select2-materialize.css') }}">
@endsection

{{-- page style --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/page-users.css') }}">
@endsection

{{-- page content --}}
@section('content')
    <!-- users edit start -->
    <div class="section users-edit">
        <div class="card">
            <div class="card-content">
                <!-- <div class="card-body"> -->
                <ul class="tabs mb-2 row">
                    <li class="tab">
                        <a class="display-flex align-items-center active" id="account-tab" href="#account">
                            <i class="material-icons mr-1">class</i><span>Class Details</span>
                        </a>
                    </li>
                    <li class="tab">
                        <a class="display-flex align-items-center" id="information-tab" href="#information">
                            <i class="material-icons mr-2">person_outline</i><span>Students</span>
                        </a>
                    </li>
                </ul>
                <div class="divider mb-3"></div>
                <div class="row">
                    <div class="col s12" id="account">
                        <!-- users edit media object start -->
                        <div class="media display-flex align-items-center mb-2 pl-2"
                            style="background-color:{{ $class->color }}; color:#efe7e7">
                            <a class="mr-2" href="#">
                                <img src="{{ asset('images/avatar/avatar-11.png') }}" alt="users avatar"
                                    class="z-depth-4 circle" height="64" width="64">
                            </a>
                            <div class="media-body">
                                <h5 class="media-heading mt-0" style="color:#efe7e7">Class Name: </h5>
                                {{-- <div class="user-edit-btns display-flex">
                                    <a href="{{ route('classes-edit', ['id' => '$class->id']) }}"
                                        class="btn-small btn-light-indigo mb-5">Change
                                        Class Color</a>
                                </div> --}}
                            </div>
                        </div>
                        <!-- users edit media object ends -->
                        <!-- users edit account form start -->
                        <form id="accountForm" method="POST"
                            action="{{ route('classes-update', ['id' => $class->id]) }}">
                            @csrf
                            {{ method_field('PATCH') }}
                            <div class="row">
                                <div class="col s12">
                                    <div class="row">
                                        <div class="col s12  m6 input-field">
                                            <input id="username" name="classCode" type="text" class="validate"
                                                value="{{ $class->classCode }}" data-error=".errorTxt1">
                                            <label for="username">Class Code</label>
                                            <small class="errorTxt1"></small>
                                        </div>
                                        <div class="input-field col s12 m6">
                                            <span><input id="color" type="color" name="color" class="validate"
                                                    value="{{ $class->color }}" required></span>
                                            <span><label for="color">Choose a Class Color</label></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12 m6 input-field">
                                            <select name="teacher">
                                                <option value="" disabled selected>Select Teacher</option>
                                                @foreach (json_decode($responseTeachers) as $teacher){
                                                    <option value="{{ $teacher->id }}"
                                                        {{ $teacher->id == $class->teacher ? 'selected = "selected"' : '' }}>{{ strtoupper($teacher->sname) }}, {{ ucwords($teacher->oname) }}
                                                    </option>
                                                    }
                                                @endforeach
                                            </select>
                                            <label>Select Teacher</label>
                                        </div>
                                        <div class="col s12 m6 input-field">
                                            <select name="status">
                                                <option value="" disabled selected>Select Status</option>
                                                @foreach (json_decode($responseStatus) as $status)
                                                    <option value="{{ $status->id }}"
                                                        {{ $status->id == $class->status ? 'selected = "selected"' : '' }}> {{ $status->status }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label>Status</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12 input-field">
                                            <input id="name" name="name" type="text" class="validate"
                                                value="{{ $class->name }}" data-error=".errorTxt2">
                                            <label for="name">Class Name</label>
                                            <small class="errorTxt2"></small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <textarea id="message5" class="materialize-textarea" maxlength="250"
                                                name="description">{{ $class->description }}</textarea>
                                            <label for="message">Class Description</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12">
                                    <div class="row">
                                        <div class="col s12 file-field input-field">
                                            <div class="btn float-right">
                                                <span>Click to Attach Image</span>
                                                <input type="file">
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input class="file-path validate" type="text" name="imagePath">
                                            </div>
                                            <span class="helper-text" style="color: red">Supported file types: .png,
                                                .jpg, .jpeg</span>
                                        </div>
                                    </div>

                                </div>
                                {{-- <div class="col s12">
                                    <table class="mt-1">
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
                                                <td>
                                                    <label>
                                                        <input type="checkbox" checked />
                                                        <span></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" />
                                                        <span></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" />
                                                        <span></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" checked />
                                                        <span></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Articles</td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" />
                                                        <span></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" checked />
                                                        <span></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" />
                                                        <span></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" checked />
                                                        <span></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Staff</td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" checked />
                                                        <span></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" checked />
                                                        <span></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" />
                                                        <span></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" />
                                                        <span></span>
                                                    </label>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- </div> -->
                                </div> --}}
                                <div class="col s12 display-flex justify-content-end mt-3">
                                    <button type="submit" class="btn indigo">
                                        Update Class Details</button>
                                    <button type="button" class="btn btn-light">Cancel</button>
                                </div>
                            </div>
                        </form>
                        <!-- users edit account form ends -->
                    </div>
                    <div class="col s12" id="information">
                        <!-- users edit Info form start -->
                        <form id="infotabForm">
                            <div class="row">
                                <div class="col s12 m6">
                                    <div class="row">
                                        <div class="col s12">
                                            <h6 class="mb-2"><i class="material-icons mr-1">link</i>Social Links
                                            </h6>
                                        </div>
                                        <div class="col s12 input-field">
                                            <input class="validate" type="text" value="https://www.twitter.com/">
                                            <label>Twitter</label>
                                        </div>
                                        <div class="col s12 input-field">
                                            <input class="validate" type="text" value="https://www.facebook.com/">
                                            <label>Facebook</label>
                                        </div>
                                        <div class="col s12 input-field">
                                            <input class="validate" type="text">
                                            <label>Google+</label>
                                        </div>
                                        <div class="col s12 input-field">
                                            <input id="linkedin" name="linkedin" class="validate" type="text">
                                            <label for="linkedin">LinkedIn</label>
                                        </div>
                                        <div class="col s12 input-field">
                                            <input class="validate" type="text" value="https://www.instagram.com/">
                                            <label>Instagram</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6">
                                    <div class="row">
                                        <div class="col s12">
                                            <h6 class="mb-4"><i
                                                    class="material-icons mr-1">person_outline</i>Personal Info</h6>
                                        </div>
                                        <div class="col s12 input-field">
                                            <input id="datepicker" name="datepicker" type="text"
                                                class="birthdate-picker datepicker" placeholder="Pick a birthday"
                                                data-error=".errorTxt4">
                                            <label for="datepicker">Birth date</label>
                                            <small class="errorTxt4"></small>
                                        </div>
                                        <div class="col s12 input-field">
                                            <select id="accountSelect">
                                                <option>USA</option>
                                                <option>India</option>
                                                <option>Canada</option>
                                            </select>
                                            <label>Country</label>
                                        </div>
                                        <div class="col s12">
                                            <label>Languages</label>
                                            <select class="browser-default" id="users-language-select2" multiple="multiple">
                                                <option value="English" selected>English</option>
                                                <option value="Spanish">Spanish</option>
                                                <option value="French">French</option>
                                                <option value="Russian">Russian</option>
                                                <option value="German">German</option>
                                                <option value="Arabic" selected>Arabic</option>
                                                <option value="Sanskrit">Sanskrit</option>
                                            </select>
                                        </div>
                                        <div class="col s12 input-field">
                                            <input id="phonenumber" type="text" class="validate"
                                                value="(+656) 254 2568">
                                            <label for="phonenumber">Phone</label>
                                        </div>
                                        <div class="col s12 input-field">
                                            <input id="address" name="address" type="text" class="validate"
                                                data-error=".errorTxt5">
                                            <label for="address">Address</label>
                                            <small class="errorTxt5"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12">
                                    <div class="input-field">
                                        <input id="websitelink" name="websitelink" type="text" class="validate">
                                        <label for="websitelink">Website</label>
                                    </div>
                                    <label>Favourite Music</label>
                                    <div class="input-field">
                                        <select class="browser-default" id="users-music-select2" multiple="multiple">
                                            <option value="Rock">Rock</option>
                                            <option value="Jazz" selected>Jazz</option>
                                            <option value="Disco">Disco</option>
                                            <option value="Pop">Pop</option>
                                            <option value="Techno">Techno</option>
                                            <option value="Folk" selected>Folk</option>
                                            <option value="Hip hop">Hip hop</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col s12">
                                    <label>Favourite movies</label>
                                    <div class="input-field">
                                        <select class="browser-default" id="users-movies-select2" multiple="multiple">
                                            <option value="The Dark Knight" selected>The Dark Knight
                                            </option>
                                            <option value="Harry Potter" selected>Harry Potter</option>
                                            <option value="Airplane!">Airplane!</option>
                                            <option value="Perl Harbour">Perl Harbour</option>
                                            <option value="Spider Man">Spider Man</option>
                                            <option value="Iron Man" selected>Iron Man</option>
                                            <option value="Avatar">Avatar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col s12 display-flex justify-content-end mt-1">
                                    <button type="submit" class="btn indigo">
                                        Save changes</button>
                                    <button type="button" class="btn btn-light">Cancel</button>
                                </div>
                            </div>
                        </form>
                        <!-- users edit Info form ends -->
                    </div>
                </div>
                <!-- </div> -->
            </div>
        </div>
    </div>
    <!-- users edit ends -->
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{ asset('vendors/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('vendors/jquery-validation/jquery.validate.min.js') }}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
    <script src="{{ asset('js/scripts/page-users.js') }}"></script>
    <script src="{{ asset('js/scripts/ui-alerts.js') }}"></script>
@endsection
