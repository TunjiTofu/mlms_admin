<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

// use Vinkla\Hashids\Facades\Hashids;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_token = session()->get('id_Token');
        $apiKey = config('firebase.api_key');
        $response = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/userauths");
        $responsePriv = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/privileges");
        $responseUserStatus = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/userstatus");

        // dd($response->json());
        if ($response->status() == 403 || $responsePriv->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->json() != null && $response->status() == 200 && $responsePriv->json() != null && $responsePriv->status() == 200 && $responseUserStatus->json() != null && $responseUserStatus->status() == 200) {
            $breadcrumbs = [
                ['link' => "/users", 'name' => "Users"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.users.index', compact(['response', 'responsePriv', 'responseUserStatus', 'breadcrumbs', 'pageConfigs']));
        } else {
            $response="You do not have permission for this action";
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/users", 'name' => "Users"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.page404', compact(['response', 'breadcrumbs', 'pageConfigs']));
        }

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id_token = session()->get('id_Token');
        $responsePriv = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/privileges");
        $responseUserStatus = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/userstatus");
        
        if ($responsePriv->status() == 403 || $responseUserStatus->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($responsePriv->status() == 200 && $responseUserStatus->status() == 200) {
            $breadcrumbs = [
                ['link' => "/users", 'name' => "Users"],
                ['link' => "/users/create", 'name' => "Create"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.users.create', compact(['responsePriv', 'responseUserStatus', 'breadcrumbs', 'pageConfigs']));
        }else {
            $response="You do not have permission for this action";
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/users", 'name' => "Users"],
                ['link' => "/users/create", 'name' => "Create"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'uname' => 'required|max:8',
            'email' => 'required|email',
            'sname' => 'required|min:2|max:255',
            'oname' => 'required|min:2|max:255',
            'role' => 'required',
            'status' => 'required',
            'phone' => 'required|size:11',
            'pword' => 'required|min:6|confirmed',
        ];

        $custom_messages = [
            'uname.required' => 'Username is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email field must contain a valid email address',
            'sname.required' => 'Surname is required',
            'oname.required' => 'Othernames is required',
            'role.required' => 'Role is required',
            'status.required' => 'Status is required',
            'phone.required' => 'Phone is required',
            'phone.size' => 'Phone number must be 11 digits',
            'pword.required' => 'Your password is required',
            'pword.confirmed' => 'Your password must match',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $data = [
            'email' => $request->email,
            'displayName' => $request->uname,
            'sname' => $request->sname,
            'oname' => $request->oname,
            'role' => $request->role,
            'status' => $request->status,
            'phoneNumber' => $request->phone,
            'password' => $request->pword,

        ];
        // dd($data);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->POST('https://us-central1-mlms-ec62a.cloudfunctions.net/userauths', $data);
        //  dd($response->body());
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 201 && $response->successful() == true) {
            return redirect('/users')->with('success', "User has been added");
        }else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/users", 'name' => "Users"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/users/'.$id);
        $responseAuth = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/userauths/'.$id);
        // dd($responseAuth->body());
        // dd($response->json());

        if ($response->status() == 403 || $responseAuth->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->json() != null && $response->status() == 200  && $responseAuth->json() != null && $responseAuth->status() == 200) {
            $user = json_decode($response);
            $userAuth = json_decode($responseAuth);
            $breadcrumbs = [
                ['link' => "/users", 'name' => "Users"],
                ['link' => "/users/view/$id", 'name' => "View User"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.users.view', compact(['user', 'userAuth', 'breadcrumbs', 'pageConfigs']));
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/users", 'name' => "Users"],
                ['link' => "/users/view/$id", 'name' => "View User"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.page404', compact(['breadcrumbs', 'pageConfigs']));
        }


        // if ($response->status() == 200 && $response->ok() == true) {
        //     $user = json_decode($response);
        //     // dd($person);
        //     $breadcrumbs = [
        //         ['link' => "/users", 'name' => "Users"],
        //         ['link' => "/users/view/$id", 'name' => "View User"],
        //     ];
        //     $pageConfigs = ['pageHeader' => true];
        //     return view('pages.admin.users.view', compact(['user', 'breadcrumbs', 'pageConfigs']));
        // }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $id_token = session()->get('id_Token');
        $responsePriv = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/privileges");
        $responseUserStatus = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/userstatus");
        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/users/' . $id);
        $responseAuth = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/userauths/'.$id);
        // dd($response->body());

        if ($response->status() == 403 || $responsePriv->status() == 403 || $responseUserStatus->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->json() != null && $response->status() == 200 && $responseAuth->json() != null && $responseAuth->status() == 200) {
            $user = json_decode($response);
            $userAuth = json_decode($responseAuth);

            // dd($person);
            $breadcrumbs = [
                ['link' => "/users", 'name' => "Users"],
                ['link' => "/users/edit/$id", 'name' => "Edit User"], 
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.users.edit', compact(['user', 'userAuth', 'responsePriv', 'responseUserStatus', 'breadcrumbs', 'pageConfigs']));
        }else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/users", 'name' => "Users"],
                ['link' => "/users/edit/$id", 'name' => "Edit User"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
        }


        // $responsePriv = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/privileges");
        // $responseUserStatus = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/userstatus");
        // if ($responsePriv->status() == 200 && $responseUserStatus->status() == 200) {
        //     $breadcrumbs = [
        //         ['link' => "/users", 'name' => "Users"],
        //         ['link' => "/users/create", 'name' => "Create"],
        //     ];
        //     $pageConfigs = ['pageHeader' => true];
        //     return view('pages.admin.users.create', compact(['responsePriv', 'responseUserStatus', 'breadcrumbs', 'pageConfigs']));
        // }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request);

        $rules = [
            'email' => 'required|email',
            'uname' => 'required|min:4|max:6',
            'sname' => 'required|min:2|max:255',
            'oname' => 'required|min:2|max:255',
            'role' => 'required',
            'status' => 'required',
            'emailVerified' => 'required|in:true,false',
            'disabled' => 'required|in:true,false',
            'phoneNumber' => 'required|size:11',
        ];

        $custom_messages = [
            'uname.required' => 'Username is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email field must contain a valid email address',
            'sname.required' => 'Surname is required',
            'oname.required' => 'Othernames is required',
            'role.required' => 'Role is required',
            'status.required' => 'Status is required',
            'emailVerified.required' => 'Email Verifed is required',
            'disabled.required' => 'Account Disable is required',
            'phoneNumber.required' => 'Phone is required',
            'phoneNumber.size' => 'Phone number must be 11 digits',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        // dd('Stop');
        $id_token = session()->get('id_Token');

        if($request->emailVerified == "true"){
            $emailVerified = true;
        }else{
            $emailVerified = false;
        }

        if($request->disabled == "true"){
            $disabled = true;
        }else{
            $disabled = false;
        }

        $data = [
            'email' => $request->email,
            'displayName' => $request->uname,
            'sname' => $request->sname, 
            'oname' => $request->oname,
            'role' => $request->role,
            'status' => $request->status,
            'phoneNumber' => $request->phoneNumber,
            'emailVerified' => $emailVerified,
            'disabled' => $disabled,

        ];
        //  dd($data);
        $response = Http::withToken($id_token)->PATCH('https://us-central1-mlms-ec62a.cloudfunctions.net/userauths/'. $id, $data);
        // dd($response->status());
        // dd($response->body));
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 201 && $response->successful() == true) {
            return redirect('/users')->with('success', "User successfully updated");
        }else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/users", 'name' => "Users"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->DELETE('https://us-central1-mlms-ec62a.cloudfunctions.net/userauths/'.$id);
        // dd($response);
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 200 && $response->successful() == true) {
            return redirect('/users')->with('success', "User successfully deleted");
        }else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/users", 'name' => "Users"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
        }
        
    }
}
