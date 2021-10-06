<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.users.index');
        // $id_token = session()->get('id_Token');
        // $response = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/users");
        // // dd($response);
        // if ($response->status() == 200 && $response->ok() == true) {

        //     return view('pages.admin.users.index', compact(['response']));
        // }
        // if ($response->status() == 403) {

        //     return redirect('/login')->with('error', 'Please login');

        // }
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
        $uname = $request->uname;
        $email = $request->email;
        $sname = $request->sname;
        $fname = $request->fname;
        $role = $request->role;
        $status = $request->status;
        $phone = $request->phone;
        $pword = $request->pword;
        $conf_pword = $request->conf_pword;
        dd($request);
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
