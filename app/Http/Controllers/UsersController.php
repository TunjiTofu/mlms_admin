<?php

namespace App\Http\Controllers;

use App\Classes\SignUpClass;
use Hashids\Hashids;
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
        $response = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/users");
        // dd($response->body());
        if ($response->status() == 200 && $response->ok() == true) {
            $breadcrumbs = [
                ['link' => "/users", 'name' => "Users"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.users.index', compact(['response','breadcrumbs','pageConfigs']));
        }
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.users.create');
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
            'uname' => 'required|min:4|max:6',
            'email' => 'required|email',
            'sname' => 'required|min:2|max:255',
            'oname' => 'required|min:2|max:255',
            'role' => 'required|in:ADM,TEA,STD',
            'status' => 'required|in:active,pending,banned',
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
        // dd('Stop');
        $id_token = session()->get('id_Token');
        $email = $request->email;
        $password = $request->pword;
        $apiKey = config('firebase.api_key');

        $auth = new SignUpClass($apiKey);
        $result = $auth->signup($email, $password);

        if ($result['success']) {
            $data = [
                'uname' => $request->uname,
                'sname' => $request->sname,
                'oname' => $request->oname,
                'role' => $request->role,
                'status' => $request->status,
                'phone' => $request->phone,
                'user_id' => $result['localId'],

            ];
            //  dd($data);
            $response = Http::withToken($id_token)->POST('https://us-central1-mlms-ec62a.cloudfunctions.net/users', $data);
            if ($response->status() == 201 && $response->successful() == true) {
                return redirect('/users')->with('success', "User with email - $email has been added");
            }
            if ($response->status() == 403) {
                return redirect('/login')->with('error', 'Unauthorized - Please login');
            }
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
        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/users/' . $id);
        // dd($response->body());
        if ($response->status() == 200 && $response->ok() == true) {
            $user = json_decode($response);
            // dd($person);
            $breadcrumbs = [
                ['link' => "/users", 'name' => "Users"],
                ['link' => "/users/view/$id", 'name' => "View User"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.users.view', compact(['user','breadcrumbs','pageConfigs']));
        }
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
        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/users/' . $id);
        // dd($response->body());
        if ($response->status() == 200 && $response->ok() == true) {
            $user = json_decode($response);
            // dd($person);
            $breadcrumbs = [
                ['link' => "/users", 'name' => "Users"],
                ['link' => "/users/edit/$id", 'name' => "Edit User"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.users.edit', compact(['user','breadcrumbs','pageConfigs']));
        }
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
        // dd($id);

        $rules = [
            'uname' => 'required|min:4|max:6',
            'sname' => 'required|min:2|max:255',
            'oname' => 'required|min:2|max:255',
            'role' => 'required|in:ADM,TEA,STD',
            'status' => 'required|in:active,pending,banned',
            'phone' => 'required|size:11',
        ];

        $custom_messages = [
            'uname.required' => 'Username is required',
            'sname.required' => 'Surname is required',
            'oname.required' => 'Othernames is required',
            'role.required' => 'Role is required',
            'status.required' => 'Status is required',
            'phone.required' => 'Phone is required',
            'phone.size' => 'Phone number must be 11 digits',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        // dd('Stop');
        $id_token = session()->get('id_Token');

        $data = [
            'uname' => $request->uname,
            'sname' => $request->sname,
            'oname' => $request->oname,
            'role' => $request->role,
            'status' => $request->status,
            'phone' => $request->phone,

        ];
        //  dd($data);
        $response = Http::withToken($id_token)->PATCH('https://us-central1-mlms-ec62a.cloudfunctions.net/users/'.$id, $data);
        // dd($response);
        if ($response->status() == 201 && $response->successful() == true) {
            return redirect('/users')->with('success', "User successfully updated");
        }
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
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
        $response = Http::withToken($id_token)->DELETE('https://us-central1-mlms-ec62a.cloudfunctions.net/users/'.$id);
        // dd($response);
        if ($response->status() == 200 && $response->successful() == true) {
            return redirect('/users')->with('success', "User successfully deleted");
        }
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }
    }
}
