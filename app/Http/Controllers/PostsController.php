<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class PostsController extends Controller 
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminPosts');
        // $responseTopics = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminTopics');
        // $responseClasses = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses");
        // $responseStatus = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/defaultstatus");
        // $responseModules = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/adminModules");
        // dd($response->json());
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 200 && $response->ok() == true) { 
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/posts", 'name' => "Posts"],
            ]; 
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.posts_s.index', compact(['response', 'breadcrumbs', 'pageConfigs']));
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/posts", 'name' => "Posts"],
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
        // dd('stop');
        $id_token = session()->get('id_Token');
        $responseClasses = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses");
        $responseStatus = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/defaultstatus");
        $responseModules = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/adminModules");
        // dd($response->json());
        if (($responseClasses->status() == 403) || ($responseStatus->status() == 403)|| ($responseModules->status() == 403)) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if (($responseModules->status() == 200 && $responseModules->ok() == true) || ($responseClasses->status() == 200 && $responseClasses->ok() == true) || ($responseStatus->status() == 200 && $responseStatus->ok() == true)) {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/posts", 'name' => "Posts"],
                ['link' => "/posts/create", 'name' => "Make Post"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.posts_s.create', compact(['responseClasses', 'responseStatus', 'responseModules', 'breadcrumbs', 'pageConfigs']));
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/posts", 'name' => "Posts"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
        }
    }

    public function getClass2Module($id)
    {
        // dd($id);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminModules/modClass/'.$id);
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }
        return $response;
    }
    
    public function getModule2Topic($id)
    {
        // dd($id);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminTopics/topicMod/'.$id);
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }
        return $response;
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
            'postTitle' => 'required|min:3|max:255',
            'postContent' => 'required|min:3',
            'classList' => 'required',
            'module' => 'required',
            'topic' => 'required',
            'status' => 'required',
        ];

        $custom_messages = [
            'postTitle.required' => 'Post Title is required',
            'postTitle.min' => 'Post Title must have a minumum of 3 characters',
            'postTitle.max' => 'Post Title can have a maximum of 255 characters',
            'postContent.required' => 'Post Content is required',
            'postContent.min' => 'Post Content  must have a minumum of 3 characters',
            'classList.required' => 'Class is required',
            'module.required' => 'Module is required',
            'topic.required' => 'Topic is required',
            'status.required' => 'Post status is required',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        // $code = generateRandomString(5);

        $sortNumber ="0";
        $user_id = session()->get('user_id');

        $data = [
            'postTitle' => $request->postTitle,
            'postContent' => $request->postContent,
            'class' => $request->classList,
            'module' => $request->module,
            'topic' => $request->topic,
            'status' => $request->status,
            'sortNumber' => $sortNumber,
            'postedBy' => $user_id,
        ];
        // dd($data);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->POST('https://us-central1-mlms-ec62a.cloudfunctions.net/adminPosts', $data);
        //  dd($response->status());
         if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 201 && $response->successful() == true) {
            return redirect('/posts')->with('success', "Post has been created");
        }else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/posts", 'name' => "Posts"],
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
        // dd($id);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminPosts/'.$id);
        // $responseAuth = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/userauths/'.$id);
        // dd($responseAuth->body());
        // dd($response->json());

        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->json() != null && $response->status() == 200) {
            $post = json_decode($response);
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/posts", 'name' => "Posts"],
                ['link' => "/posts/view/$id", 'name' => "View Post"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.posts_s.view', compact(['post', 'breadcrumbs', 'pageConfigs']));
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/posts", 'name' => "Posts"],
                ['link' => "/posts/view/$id", 'name' => "View Post"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.page404', compact(['breadcrumbs', 'pageConfigs']));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd('stop');
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/adminPosts/".$id);
        $responseClasses = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses");
        $responseStatus = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/defaultstatus");
        $responseModules = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/adminModules");
        // dd($response->json());
        if (($response->status() == 403) || ($responseClasses->status() == 403) || ($responseStatus->status() == 403)|| ($responseModules->status() == 403)) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if (($response->status() == 200 && $response->ok() == true) || ($responseModules->status() == 200 && $responseModules->ok() == true) || ($responseClasses->status() == 200 && $responseClasses->ok() == true) || ($responseStatus->status() == 200 && $responseStatus->ok() == true)) {
            $post = json_decode($response);
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/posts", 'name' => "Posts"],
                ['link' => "/posts/edit", 'name' => "Edit Post"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.posts_s.edit', compact(['post', 'responseClasses', 'responseStatus', 'responseModules', 'breadcrumbs', 'pageConfigs']));
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/posts", 'name' => "Posts"],
                ['link' => "/posts/edit", 'name' => "Edit Post"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
        }
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
            'postTitle' => 'required|min:3|max:255',
            'postContent' => 'required|min:3',
            'classList' => 'required',
            'status' => 'required',
            // 'module' => 'required',
            // 'topic' => 'required',
        ];

        $custom_messages = [
            'postTitle.required' => 'Post Title is required',
            'postTitle.min' => 'Post Title must have a minumum of 3 characters',
            'postTitle.max' => 'Post Title can have a maximum of 255 characters',
            'postContent.required' => 'Post Content is required',
            'postContent.min' => 'Post Content  must have a minumum of 3 characters',
            'classList.required' => 'Class is required',
            'status.required' => 'Post status is required',
            // 'module.required' => 'Module is required',
            // 'topic.required' => 'Topic is required',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        // $code = generateRandomString(5);

        $sortNumber ="0";
        // $user_id = session()->get('user_id');

        $updatedModule='';
        if($request->module == null){
            $updatedModule = $request->currentModule; 
        }
        if($request->module != null){
            $updatedModule = $request->module; 
        }

        $updatedTopic='';
        if($request->topic == null){
            $updatedTopic = $request->currentTopic; 
        }
        if($request->topic != null){
            $updatedModule = $request->topic; 
        }

        $data = [
            'postTitle' => $request->postTitle,
            'postContent' => $request->postContent,
            'class' => $request->classList,
            'module' => $updatedModule,
            'topic' => $updatedTopic,
            'status' => $request->status,
            'sortNumber' => $sortNumber,
            // 'postedBy' => $user_id,
        ];
        // dd($data);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->PATCH('https://us-central1-mlms-ec62a.cloudfunctions.net/adminPosts/'.$id, $data);
        //  dd($response->status());
         if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 201 && $response->successful() == true) {
            return redirect('/posts')->with('success', "Post has been updated");
        }else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/posts", 'name' => "Posts"],
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
        $response = Http::withToken($id_token)->DELETE('https://us-central1-mlms-ec62a.cloudfunctions.net/adminPosts/'.$id);
        // dd($response);
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 200 && $response->successful() == true) {
            return redirect('/posts')->with('success', "Post successfully deleted");
        }else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/posts", 'name' => "Posts"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
        }
    }
}
