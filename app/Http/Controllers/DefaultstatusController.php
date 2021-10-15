<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class DefaultstatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/defaultstatus');
        // dd($response->json());
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 200 && $response->ok() == true) {
            $breadcrumbs = [
            ['link' => "#", 'name' => "All Status"], 
            ['link' => "/defaultstatus", 'name' => "User Status"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.default_status.index', compact(['response', 'breadcrumbs', 'pageConfigs']));
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
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
            'id.required' => 'status ID is required',
            'id.string' => 'status ID must be a text value',
            'id.min' => 'Status ID must be a minimum of 2 characters',
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
        $response = Http::withToken($id_token)->POST('https://us-central1-mlms-ec62a.cloudfunctions.net/defaultstatus', $data);
        // dd($response->status());
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 201 && $response->successful() == true) {
            return redirect('/defaultstatus')->with('success', 'Status Created');
        }else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
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
        $response = Http::withToken($id_token)->PATCH('https://us-central1-mlms-ec62a.cloudfunctions.net/defaultstatus/'.$id, $data);
        // dd($response->status());
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 201 && $response->successful() == true) {
            return redirect('/defaultstatus')->with('success', 'Default Status Updated');
        }else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
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
        //  dd($id);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->DELETE('https://us-central1-mlms-ec62a.cloudfunctions.net/defaultstatus/'.$id);
        // dd($response);
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 200 && $response->successful() == true) {
            return redirect('/defaultstatus')->with('success', "Default Status Deleted");
        }else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
        }
    }
}
