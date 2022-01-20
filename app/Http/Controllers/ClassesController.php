<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; 
use Illuminate\Support\Facades\Validator;
use App\Classes\RandomClassCode;


class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_token = session()->get('id_Token');
        $apiKey = config('firebase.api_key');
        $response = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses");
        $responseTeachers = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses/getTeachers");
        $responseStatus = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/defaultstatus");
        // $responsePriv = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/privileges");
        // $responseUserStatus = Http::wlithToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/userstatus");

        // dd($response->body());
        if ($response->status() == 403 || $responseTeachers->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if (($response->json() != null && $response->status() == 200) || ($responseTeachers->json() != null && $responseTeachers->status() == 200)) {
            $breadcrumbs = [
                ['link' => "/classes", 'name' => "Classes"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.classes_s.index', compact(['response', 'responseTeachers', 'responseStatus', 'breadcrumbs', 'pageConfigs']));
        } else {
            $response="You do not have permission for this action";
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/classes", 'name' => "Classes"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.page404', compact(['response', 'breadcrumbs', 'pageConfigs']));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses/getTeachers");
        $responseStatus = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/defaultstatus");
        // dd($responseStatus->body());
        
        if ($response->status() == 403 || $responseStatus->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 200 && $responseStatus->status() == 200) {
            $breadcrumbs = [
                ['link' => "/classes", 'name' => "Classes"],
                ['link' => "/classes/create", 'name' => "Create Class"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.classes_s.create', compact(['response', 'responseStatus', 'breadcrumbs', 'pageConfigs']));
        }else {
            $response="You do not have permission for this action";
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/classes", 'name' => "Classes"],
                ['link' => "/classes/create", 'name' => "Create Class"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
        }
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
            'name' => 'required|min:3|max:255',
            'teacher' => 'required',
            'description' => 'required|max:250',
            'status' => 'required',
            'color' => 'required',
        ];

        $custom_messages = [
            'name.required' => 'Class name is required',
            'teacher.required' => 'A Teacher is required for the class',
            'description.required' => 'Class description is required',
            'description.max' => 'Class description can only have a maximum of 250 characters',
            'status.required' => 'Class status is required',
            'color.required' => 'Class color is required',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        // $code = generateRandomString(5);

        $cCode = new RandomClassCode();
        $classCode = $cCode->generateRandomString(6);

        $data = [
            'name' => $request->name,
            'teacher' => $request->teacher,
            'description' => $request->description,
            'status' => $request->status,
            'color' => $request->color,
            'imagePath' => $request->imagePath,
            'createdByAdmin' => true,
            'classCode' => $classCode,
        ];
        // dd($data);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->POST('https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses', $data);
        //  dd($response->status());
         if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 201 && $response->successful() == true) {
            return redirect('/classes')->with('success', "Class has been created");
        }else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/classes", 'name' => "Classes"],
                ['link' => "/classes/create", 'name' => "Create Class"],
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
        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses/'.$id);
        // $responseAuth = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/userauths/'.$id);
        // dd($responseAuth->body());
        // dd($response->json());

        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->json() != null && $response->status() == 200) {
            $class = json_decode($response);
            // $userAuth = json_decode($responseAuth);
            $breadcrumbs = [
                ['link' => "/classes", 'name' => "Classes"],
                ['link' => "/classes/view/$id", 'name' => "View Class"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.classes_s.view', compact(['class', 'breadcrumbs', 'pageConfigs']));
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/classes", 'name' => "Classes"],
                ['link' => "/classes/view/$id", 'name' => "View Class"],
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
        // $breadcrumbs = [
        //     ['link' => "/classes", 'name' => "Classes"],
        //         ['link' => "/classes/edit/$id", 'name' => "Edit Class"],
        // ];
        // $pageConfigs = ['pageHeader' => true];
        // return view('pages.admin.classes_s.edit', compact(['breadcrumbs', 'pageConfigs']));

        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses/'.$id);
        $responseStatus = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/defaultstatus");
        $responseTeachers = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses/getTeachers");
        // dd($responseTeachers->json());

        if ($response->status() == 403 || $responseStatus->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->json() != null && $response->status() == 200 && $responseStatus->json() != null && $responseStatus->status() == 200 && $responseTeachers->json() != null && $responseTeachers->status() == 200) {
            $class = json_decode($response);
            // $classStatus = json_decode($responseStatus);

            // dd($classStatus);
            $breadcrumbs = [
                ['link' => "/classes", 'name' => "Classes"],
                ['link' => "/classes/edit/$id", 'name' => "Edit Class"], 
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.classes_s.edit', compact(['class', 'responseStatus', 'responseTeachers', 'breadcrumbs', 'pageConfigs']));
        }else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/classes", 'name' => "Classes"],
                ['link' => "/classes/edit/$id", 'name' => "Edit Class"], 
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
            'name' => 'required|min:3|max:255',
            'teacher' => 'required',
            'description' => 'required|max:250',
            'status' => 'required',
            'color' => 'required',
            'classCode' => 'required',
        ];

        $custom_messages = [
            'name.required' => 'Class name is required',
            'classCode.required' => 'Class Code is required',
            'teacher.required' => 'A Teacher is required for the class',
            'description.required' => 'Class description is required',
            'description.max' => 'Class description can only have a maximum of 250 characters',
            'status.required' => 'Class status is required',
            'color.required' => 'Class color is required',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        // $code = generateRandomString(5);

        $data = [
            'name' => $request->name,
            'teacher' => $request->teacher,
            'description' => $request->description,
            'status' => $request->status,
            'color' => $request->color,
            'imagePath' => $request->imagePath,
            'classCode' => $request->classCode,
            'updatedByAdmin' => "Yes",
        ];
        // dd($data);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->PATCH('https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses/'.$id,  $data);
        //  dd($response->status());
         if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 201 && $response->successful() == true) {
            return redirect('/classes')->with('success', "Class has been updated");
        }else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/classes", 'name' => "Classes"],
                ['link' => "/classes/create", 'name' => "Create Class"],
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
        $response = Http::withToken($id_token)->DELETE('https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses/'.$id);
        // dd($response);
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 200 && $response->successful() == true) {
            return redirect('/classes')->with('success', "Clasas successfully deleted");
        }else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/classes", 'name' => "Classes"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
        }
    }

    
}
