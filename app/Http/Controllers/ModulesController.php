<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class ModulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminModules');
        $responseClasses = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses");
        $responseStatus = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/defaultstatus");
        // dd($response->json());
        if (($responseClasses->status() == 403) || ($responseStatus->status() == 403)) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if (($responseClasses->status() == 200 && $responseClasses->ok() == true)|| ($responseStatus->status() == 200 && $responseStatus->ok() == true)) {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/modules", 'name' => "Modules"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.modules_s.index', compact(['response', 'responseClasses', 'responseStatus', 'breadcrumbs', 'pageConfigs']));
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/privileges", 'name' => "Privileges"],
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
            'moduleName' => 'required|min:3|max:255',
            'status' => 'required',
            'class' => 'required',
        ];

        $custom_messages = [
            'moduleName.required' => 'Module name is required',
            'status.required' => 'Module status is required',
            'class.required' => 'Class Name is required',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        // $code = generateRandomString(5);

        $sortNumber ="0";

        $data = [
            'moduleName' => $request->moduleName,
            'status' => $request->status,
            'class' => $request->class,
            'sortNumber' => $sortNumber,
        ];
        // dd($data);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->POST('https://us-central1-mlms-ec62a.cloudfunctions.net/adminModules', $data);
        //  dd($response->status());
         if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 201 && $response->successful() == true) {
            return redirect('/modules')->with('success', "Module has been created");
        }else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/modules", 'name' => "Modules"],
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
        // dd($id);
        $rules = [
            'moduleName' => 'required|min:3|max:255',
            'status' => 'required',
            'class' => 'required',
        ];

        $custom_messages = [
            'moduleName.required' => 'Module name is required',
            'status.required' => 'Module status is required',
            'class.required' => 'Class Name is required',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $sortNumber ="0";
        $data = [
            'moduleName' => $request->moduleName,
            'status' => $request->status,
            'class' => $request->class,
            'sortNumber' => $sortNumber,
        ];
        // dd($data);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->PATCH('https://us-central1-mlms-ec62a.cloudfunctions.net/adminModules/'.$id,  $data);
        //  dd($response->status());
         if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 201 && $response->successful() == true) {
            return redirect('/modules')->with('success', "Module has been updated");
        }else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/modules", 'name' => "Modules"],
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
        $response = Http::withToken($id_token)->DELETE('https://us-central1-mlms-ec62a.cloudfunctions.net/adminModules/'.$id);
        // dd($response);
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 200 && $response->successful() == true) {
            return redirect('/modules')->with('success', "Clasas successfully deleted");
        }else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/modules", 'name' => "Modules"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
        }
    }
}
