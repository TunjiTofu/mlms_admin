<?php

namespace App\Http\Controllers;

use App\Classes\LoginClass;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;


class IndexController extends Controller
{
    public function index()
    {
        return view('pages.authentication.user-login');
    }

    public function auth(Request $request)
    {
        $rules=[
            'uname'=>'required|email',
            'pword'=>'required',
        ];
 
        $custom_messages=[
            'uname.required'=>'Your username is required',
            'uname.email'=>'Email field must contain a valid email address',
            'pword.required'=>'Your password is required'
        ];
 
        $validator=Validator::make($request->all(), $rules, $custom_messages);
        if($validator->fails())
        {
            // dd($validator->errors());
            return back()->withErrors($validator->errors()); 
        }


        $email = $request->uname;
        $password = $request->pword;
        $apiKey = config('firebase.api_key');

        $auth = new LoginClass($apiKey);
        $result = $auth->login($email, $password);

        // dd($result);
        if ($result['success']) {
            session()->put('id_Token', $result['idToken']);
            session()->put('user_email', $result['email']);
            session()->put('user_id', $result['localId']);
            return redirect('/')->with('success','Login Successful');
        } else {
            $success =  $result['success'];
            $msg =  $result['message'];
            session()->put('id_Token','');
            session()->put('user_email', '');
            // return view('index', compact(['success', 'msg']));

            return back()->with('error',$msg);
        }
    }

    public function register()
    {
        return view('pages.authentication.user-register');
    }

    public function dashboard()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Dashboard"],
        ];
        $pageConfigs = ['pageHeader' => true];

        return view('pages.dashboard', ['pageConfigs' => $pageConfigs], ['breadcrumbs' => $breadcrumbs]);
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->flush();
        // dd($request);
        return redirect('/login');
    }
}
