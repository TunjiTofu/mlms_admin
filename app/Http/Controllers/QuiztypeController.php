<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class QuiztypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/quiztypes');
        // dd($response->body());
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 200 && $response->ok() == true) {
            $breadcrumbs = [
                ['link' => "#", 'name' => "Configuration"],
                ['link' => "/quiztype", 'name' => "Quiz Types"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.quiz_types.index', compact(['response', 'breadcrumbs', 'pageConfigs']));
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "#", 'name' => "Configuration"],
                ['link' => "/quiztype", 'name' => "Quiz Types"],
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
            'id.required' => 'Quiz type ID is required',
            'id.string' => 'Quiz type ID must be a text value',
            'id.min' => 'Quiz type ID must be a minimum of 2 characters',
            'type.required' => 'Quiz type Title is required',
            'type.string' => 'Quiz type Title must be a text value',
            'type.min' => 'Quiz type Title must be a minimum of 3 characters',
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
        $response = Http::withToken($id_token)->POST('https://us-central1-mlms-ec62a.cloudfunctions.net/quiztypes', $data);
        // dd($response->status());
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 201 && $response->successful() == true) {
            return redirect('/quiztype')->with('success', 'Quiz Type Created');
        }else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "#", 'name' => "Configuration"],
                ['link' => "/quiztype", 'name' => "Quiz Types"],
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
            'type.required' => 'Quiz Type Title is required',
            'type.string' => 'Quiz Type Title must be a text value',
            'type.min' => 'Quiz Type Title must be a minimum of 3 characters',
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
        $response = Http::withToken($id_token)->PATCH('https://us-central1-mlms-ec62a.cloudfunctions.net/quiztypes/'.$id, $data);
        // dd($response->status());
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 201 && $response->successful() == true) {
            return redirect('/quiztype')->with('success', 'Quiz Type Updated');
        }else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "#", 'name' => "Configuration"],
                ['link' => "/quiztype", 'name' => "Quiz Types"],
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
         $response = Http::withToken($id_token)->DELETE('https://us-central1-mlms-ec62a.cloudfunctions.net/quiztypes/'.$id);
         // dd($response);
         if ($response->status() == 403) {
             return redirect('/login')->with('error', 'Unauthorized - Please login');
         }
 
         if ($response->status() == 200 && $response->successful() == true) {
             return redirect('/quiztype')->with('success', "Quiz Type Deleted");
         }else {
             $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "#", 'name' => "Configuration"],
                ['link' => "/quiztype", 'name' => "Quiz Types"],
                ['link' => "#", 'name' => "404 Page"],
             ];
             $pageConfigs = ['pageHeader' => true];
             return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
         }
    }
}
