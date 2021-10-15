<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ResourcetypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/resourcetypes');
        // dd($response->body());
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 200 && $response->ok() == true) {
            $breadcrumbs = [
                ['link' => "#", 'name' => "Configuration"],
                ['link' => "/resourcetype", 'name' => "Resource Types"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.resource_types.index', compact(['response', 'breadcrumbs', 'pageConfigs']));
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "#", 'name' => "Configuration"],
                ['link' => "/resourcetype", 'name' => "Resource Types"],
                ['link' => "#", 'name' => "404 Page"],
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
            'type' => 'required|string|min:3|max:255',
        ];

        $custom_messages = [
            'id.required' => 'Resource type ID is required',
            'id.string' => 'Resource type ID must be a text value',
            'id.min' => 'Resource type ID must be a minimum of 2 characters',
            'type.required' => 'Resource type Title is required',
            'type.string' => 'Resource type Title must be a text value',
            'type.min' => 'Resource type Title must be a minimum of 3 characters',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        // dd("stop");

        $id_token = session()->get('id_Token');
        $data = [
            'id' => $request->id,
            'type' => $request->type,
        ];
        //  dd($data);
        $response = Http::withToken($id_token)->POST('https://us-central1-mlms-ec62a.cloudfunctions.net/resourcetypes', $data);
        // dd($response->status());
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 201 && $response->successful() == true) {
            return redirect('/resourcetype')->with('success', 'Resource Type Created');
        }else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "#", 'name' => "Configuration"],
                ['link' => "/resourcetype", 'name' => "Resource Types"],
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
            'type' => 'required|string|min:3|max:255',
        ];

        $custom_messages = [
            'type.required' => 'Resource Type Title is required',
            'type.string' => 'Resource Type Title must be a text value',
            'type.min' => 'Resource Type Title must be a minimum of 3 characters',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        // dd("stop");

        $id_token = session()->get('id_Token');
        $data = [
            'type' => $request->type,
        ];
        //  dd($data);
        $response = Http::withToken($id_token)->PATCH('https://us-central1-mlms-ec62a.cloudfunctions.net/resourcetypes/'.$id, $data);
        // dd($response->status());
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 201 && $response->successful() == true) {
            return redirect('/resourcetype')->with('success', 'Resource Type Updated');
        }else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "#", 'name' => "Configuration"],
                ['link' => "/resourcetype", 'name' => "Resource Types"],
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
        //  dd($id);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->DELETE('https://us-central1-mlms-ec62a.cloudfunctions.net/resourcetypes/'.$id);
        // dd($response);
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 200 && $response->successful() == true) {
            return redirect('/resourcetype')->with('success', "Resource Type Deleted");
        }else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "#", 'name' => "Configuration"],
                ['link' => "/resourcetype", 'name' => "Resource Types"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
        }
    }
}
