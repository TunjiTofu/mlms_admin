<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "/classes", 'name' => "Classes"],
            ['link' => "/classes/create", 'name' => "Create Class"],
        ];
        $pageConfigs = ['pageHeader' => true];
        return view('pages.admin.classes_s.create', compact(['breadcrumbs', 'pageConfigs']));
        
        // $id_token = session()->get('id_Token');
        // $responsePriv = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/privileges");
        // $responseUserStatus = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/userstatus");
        
        // if ($responsePriv->status() == 403 || $responseUserStatus->status() == 403) {
        //     return redirect('/login')->with('error', 'Unauthorized - Please login');
        // }

        // if ($responsePriv->status() == 200 && $responseUserStatus->status() == 200) {
        //     $breadcrumbs = [
        //         ['link' => "/users", 'name' => "Users"],
        //         ['link' => "/users/create", 'name' => "Create"],
        //     ];
        //     $pageConfigs = ['pageHeader' => true];
        //     return view('pages.admin.users.create', compact(['responsePriv', 'responseUserStatus', 'breadcrumbs', 'pageConfigs']));
        // }else {
        //     $response="You do not have permission for this action";
        //     $breadcrumbs = [
        //         ['link' => "/", 'name' => "Dashboard"],
        //         ['link' => "/users", 'name' => "Users"],
        //         ['link' => "/users/create", 'name' => "Create"],
        //         ['link' => "#", 'name' => "404 Page"],
        //     ];
        //     $pageConfigs = ['pageHeader' => true];
        //     return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
        // }
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
