<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {

    }

    public function postComments($id)
    {
        // $id_token = session()->get('id_Token');
        // $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminPosts/'.$id);
        // // dd($response->status());
        // $post = json_decode($response);
        //     $breadcrumbs = [
        //         ['link' => "/", 'name' => "Dashboard"],
        //         ['link' => "/posts", 'name' => "Posts"],
        //         ['link' => "/posts/view/$id", 'name' => "View Post"],
        //     ];
        //     $pageConfigs = ['pageHeader' => true];
        //     return view('pages.admin.comments.view', compact(['post', 'breadcrumbs', 'pageConfigs']));

        $id_token = session()->get('id_Token');
        $responsePost = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminPosts/' . $id);
        $responseComments = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminComments/parent');
        // $responseComments = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminComments/child/LPO6OVKk3hKw08TuwdW8');
        
        // dd($responseComments->json());
        if (($responsePost->status() == 403) || ($responseComments->status() == 403)) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if (($responsePost->status() == 200 && $responsePost->ok() == true) || ($responseComments->status() == 200 && $responseComments->ok() == true)) {
            $post = json_decode($responsePost);
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/posts", 'name' => "Posts"],
                ['link' => "/posts/view/$id", 'name' => "View Post"], 
                ['link' => "/comments/postcomments/$id", 'name' => "Comments"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.comments.view', compact(['responseComments', 'post', 'breadcrumbs', 'pageConfigs']));
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeParent(Request $request)
    {
        // dd($request);
        $rules = [
            'parentComment' => 'required|min:2',
            'postId' => 'required',
        ];

        $custom_messages = [
            'parentComment.required' => 'Post Comment is required',
            'parentComment.min' => 'Post Comment must have a minumum of 2 characters',
            'postId.required' => 'Post Id is required',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        // $code = generateRandomString(5);

        $user_id = session()->get('user_id');

        $data = [
            'comment' => $request->parentComment,
            'postId' => $request->postId,
            'userId' => $user_id,
            'isParentComment' => true,
            'isChildComment' => false,
            'parentId' => null,
            'status' => "active",
        ];
        // dd($data);

        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->POST('https://us-central1-mlms-ec62a.cloudfunctions.net/adminComments', $data);
        //  dd($response->status());
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 201 && $response->successful() == true) {
            return redirect("comments/postcomments/$request->postId")->with('success', "Comment Posted");
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

    public function storeChild(Request $request)
    {
        // dd($request);
        $rules = [
            'childComment' => 'required|min:2',
            'postId' => 'required',
            'parentCommentId' => 'required',
        ];

        $custom_messages = [
            'childComment.required' => 'Post Comment is required',
            'childComment.min' => 'Post Comment must have a minumum of 2 characters',
            'postId.required' => 'postId is required',
            'parentCommentId.required' => 'parentCommentId is required',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        // $code = generateRandomString(5);

        $user_id = session()->get('user_id');

        $data = [
            'comment' => $request->childComment,
            'postId' => $request->postId,
            'userId' => $user_id,
            'isParentComment' => false,
            'isChildComment' => true,
            'parentId' =>  $request->parentCommentId,
            'status' => "active",
        ];
        // dd($data);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->POST('https://us-central1-mlms-ec62a.cloudfunctions.net/adminComments', $data);
        //  dd($response->status());
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 201 && $response->successful() == true) {
            return redirect("comments/postcomments/$request->postId")->with('success', "Comment Posted");
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


    public function disableComments($id, $currentstatus)
    {
        // dd($id);
        // dd($currentstatus);

        $newStatus = '';
        if($currentstatus == 'active'){
            $newStatus = 'disabled';
        }
        if($currentstatus == 'disabled'){
            $newStatus = 'active';
        }

        $data = [
            'status' => $newStatus,
        ];

        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->PATCH('https://us-central1-mlms-ec62a.cloudfunctions.net/adminComments/'.$id, $data);
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }
        return $response;
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
    public function destroy($id, $userid)
    {
        // dd($id);
        // dd($currentstatus);

        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->DELETE('https://us-central1-mlms-ec62a.cloudfunctions.net/adminComments/'.$id.'/'.$userid);
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }
        if ($response->status() == 200 && $response->successful() == true) {
            return json_encode(['success' => 200], $response->status());
        }
    }
}
