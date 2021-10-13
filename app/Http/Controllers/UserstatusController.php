<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class UserstatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/userstatus');
        // dd($response->json());
        if ($response->status() == 200 && $response->ok() == true) {
            $breadcrumbs = [
                ['link' => "/userstatus", 'name' => "User Status"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.users_status.index', compact(['response', 'breadcrumbs', 'pageConfigs']));
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $rules = [
            'id' => 'required|string|min:2',
            'status' => 'required|string|min:3|max:255',
        ];

        $custom_messages = [
            'id.required' => 'User status ID is required',
            'id.string' => 'User status ID must be a text value',
            'id.min' => 'User status ID must be a minimum of 2 characters',
            'status.required' => 'Status Title is required',
            'status.string' => 'Status Title must be a text value',
            'status.min' => 'Status Title must be a minimum of 3 characters',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        // dd("stop");

        $id_token = session()->get('id_Token');
        $data = [
            'id' => $request->id,
            'status' => $request->status,
        ];
        //  dd($data);
        $response = Http::withToken($id_token)->POST('https://us-central1-mlms-ec62a.cloudfunctions.net/userstatus', $data);
        // dd($response->status());
        if ($response->status() == 201 && $response->successful() == true) {
            return redirect('/userstatus')->with('success', 'User Status Created');
        }
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            'status' => 'required|string|min:3|max:255',
        ];

        $custom_messages = [
            'status.required' => 'Status Title is required',
            'status.string' => 'Status Title must be a text value',
            'status.min' => 'Status Title must be a minimum of 3 characters',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        // dd("stop");

        $id_token = session()->get('id_Token');
        $data = [
            'status' => $request->status,
        ];
        //  dd($data);
        $response = Http::withToken($id_token)->PATCH('https://us-central1-mlms-ec62a.cloudfunctions.net/userstatus/'.$id, $data);
        // dd($response->status());
        if ($response->status() == 201 && $response->successful() == true) {
            return redirect('/userstatus')->with('success', 'User Status Updated');
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
        //  dd($id);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->DELETE('https://us-central1-mlms-ec62a.cloudfunctions.net/userstatus/'.$id);
        // dd($response);
        if ($response->status() == 200 && $response->successful() == true) {
            return redirect('/userstatus')->with('success', "User Status Deleted");
        }
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }
    }
}
