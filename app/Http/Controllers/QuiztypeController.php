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
        $breadcrumbs = [
            ['link' => "#", 'name' => "Configuration"],
            ['link' => "/quiztype", 'name' => "Quiz Types"],
        ];
        $pageConfigs = ['pageHeader' => true];
        return view('pages.admin.quiz_types.index', compact(['breadcrumbs', 'pageConfigs']));

        $id_token = session()->get('id_Token');
        // $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/userstatus');
        // dd($response->json());
        // if ($response->status() == 403) {
        //     return redirect('/login')->with('error', 'Unauthorized - Please login');
        // }

        // if ($response->status() == 200 && $response->ok() == true) {
        //     $breadcrumbs = [
        //         ['link' => "/defaultstatus", 'name' => "User Status"],
        //     ];
        //     $pageConfigs = ['pageHeader' => true];
        //     return view('pages.admin.default_status.index', compact(['response', 'breadcrumbs', 'pageConfigs']));
        // } else {
        //     $breadcrumbs = [
        //         ['link' => "/", 'name' => "Dashboard"],
        //     ];
        //     $pageConfigs = ['pageHeader' => true];
        //     return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
        // }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
