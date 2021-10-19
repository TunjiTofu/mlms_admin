<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class TopicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd('stop');
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminTopics');
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
                ['link' => "/topics", 'name' => "Topics"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.topics.index', compact(['response', 'breadcrumbs', 'pageConfigs']));
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
                ['link' => "/topics", 'name' => "Topics"],
                ['link' => "/topics/create", 'name' => "Create Topic"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.topics.create', compact(['responseClasses', 'responseStatus', 'responseModules', 'breadcrumbs', 'pageConfigs']));
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

    public function getModuleClass($id)
    {
        // dd($id);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminModules/modClass/'.$id);
        // $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminModules/modClas2/'.$id);
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
            'topicName' => 'required|min:3|max:255',
            'status' => 'required',
            'classList' => 'required',
            'module' => 'required',
        ];

        $custom_messages = [
            'topicName.required' => 'Topic name is required',
            'status.required' => 'Topic status is required',
            'classList.required' => 'Class Name is required',
            'module.required' => 'Module Name is required',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        // $code = generateRandomString(5);

        $sortNumber ="0";

        $data = [
            'topicName' => $request->topicName,
            'status' => $request->status,
            'class' => $request->classList,
            'module' => $request->module,
            'sortNumber' => $sortNumber,
        ];
        // dd($data);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->POST('https://us-central1-mlms-ec62a.cloudfunctions.net/adminTopics', $data);
        //  dd($response->status());
         if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 201 && $response->successful() == true) {
            return redirect('/topics')->with('success', "Topic has been created");
        }else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/topics", 'name' => "Topics"],
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
        // dd($id);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/adminTopics/".$id);
        $responseClasses = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses");
        $responseStatus = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/defaultstatus");
        $responseModules = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/adminModules");
        // dd($response->json());
        if (($response->status() == 403) || ($responseClasses->status() == 403) || ($responseStatus->status() == 403)|| ($responseModules->status() == 403)) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if (($response->status() == 200 && $response->ok() == true) || ($responseModules->status() == 200 && $responseModules->ok() == true) || ($responseClasses->status() == 200 && $responseClasses->ok() == true) || ($responseStatus->status() == 200 && $responseStatus->ok() == true)) {
            
            $topic = json_decode($response);
            // dd($topic);
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/topics", 'name' => "Topics"],
                ['link' => "/topics/edit/$id", 'name' => "Edit Topic"], 
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.topics.edit', compact(['topic', 'responseClasses', 'responseStatus', 'responseModules', 'breadcrumbs', 'pageConfigs']));
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
            'topicName' => 'required|min:3|max:255',
            'status' => 'required',
            'classList' => 'required',
            // 'module' => 'required',
            'currentModule' => 'required',
        ];

        $custom_messages = [
            'topicName.required' => 'Topic name is required',
            'status.required' => 'Topic status is required',
            'classList.required' => 'Class Name is required',
            // 'module.required' => 'Module Name is required',
            'currentModule.required' => 'Current Module Name is required',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        // $code = generateRandomString(5);

        $sortNumber ="0"; // Display order in the front end

        $updatedModule='';
        if($request->module == null){
            $updatedModule = $request->currentModule; 
        }
        if($request->module != null){
            $updatedModule = $request->module; 
        }

        $data = [
            'topicName' => $request->topicName,
            'status' => $request->status,
            'class' => $request->classList,
            'module' => $updatedModule,
            'sortNumber' => $sortNumber,
        ];
        // dd($data);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->PATCH('https://us-central1-mlms-ec62a.cloudfunctions.net/adminTopics/'.$id,  $data);
        //  dd($response->status());
         if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 201 && $response->successful() == true) {
            return redirect('/topics')->with('success', "Topic has been updated");
        }else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/topics", 'name' => "Topics"],
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
        $response = Http::withToken($id_token)->DELETE('https://us-central1-mlms-ec62a.cloudfunctions.net/adminTopics/'.$id);
        // dd($response);
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 200 && $response->successful() == true) {
            return redirect('/topics')->with('success', "Module successfully deleted");
        }else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/topics", 'name' => "Topics"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
        }
    }
}
