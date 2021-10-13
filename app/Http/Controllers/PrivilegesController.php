<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PrivilegesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/privileges');
        // dd($response->json());
        if ($response->status() == 200 && $response->ok() == true) {
            $breadcrumbs = [
                ['link' => "/privileges", 'name' => "Privileges"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.privileges.index', compact(['response', 'breadcrumbs', 'pageConfigs']));
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
        $rules = [
            'code' => 'required|size:3',
            'title' => 'required|min:3|max:255',
        ];

        $custom_messages = [
            'code.required' => 'Privilege code is required',
            'code.size' => 'Privilege code must be 3 characters',
            'title.required' => 'Title is required',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        // dd("stop");

        $id_token = session()->get('id_Token');
        $data = [
            'code' => strtoupper($request->code),
            'title' => $request->title,
        ];
        //  dd($data);
        $response = Http::withToken($id_token)->POST('https://us-central1-mlms-ec62a.cloudfunctions.net/privileges', $data);
        // dd($response->status());
        if ($response->status() == 201 && $response->successful() == true) {
            return redirect('/privileges')->with('success', 'User Privilege Created');
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
        $rules = [
            'title' => 'required|min:3|max:255',
        ];

        $custom_messages = [
            'title.required' => 'Title is required',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        // dd("stop");

        $id_token = session()->get('id_Token');
        $data = [
            'title' => $request->title,
        ];
        //  dd($data);
        $response = Http::withToken($id_token)->PATCH('https://us-central1-mlms-ec62a.cloudfunctions.net/privileges/'.$id, $data);
        // dd($response->status());
        if ($response->status() == 201 && $response->successful() == true) {
            return redirect('/privileges')->with('success', 'User Privilege Updated');
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
         $response = Http::withToken($id_token)->DELETE('https://us-central1-mlms-ec62a.cloudfunctions.net/privileges/'.$id);
         // dd($response);
         if ($response->status() == 200 && $response->successful() == true) {
             return redirect('/privileges')->with('success', "User Privilege Deleted");
         }
         if ($response->status() == 403) {
             return redirect('/login')->with('error', 'Unauthorized - Please login');
         }
    }
}
