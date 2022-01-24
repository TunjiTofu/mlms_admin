<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

// use App\Classes\RandomClassCode;

class QuizController extends Controller
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
        $response = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/quizzes");
        $responseClasses = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses");
        $responseStatus = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/defaultstatus");
        // $responsePriv = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/privileges");
        // $responseUserStatus = Http::wlithToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/userstatus");

        // dd($response->body());
        // dd($response->json());

        if (($response->status() == 403) || ($responseClasses->status() == 403) || ($responseStatus->status() == 403)) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if (($response->json() != null && $response->status() == 200) || ($responseClasses->json() != null && $responseClasses->status() == 200) || ($responseStatus->json() != null && $responseStatus->status() == 200)) {
            $breadcrumbs = [
                ['link' => "/quizzes", 'name' => "Quizzes"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.quizzes.index', compact(['response', 'responseClasses', 'responseStatus', 'breadcrumbs', 'pageConfigs']));
        } else {
            $response = "You do not have permission for this action";
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
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
        // $responseQuizTypes = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/quiztypes");
        $responseStatus = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/defaultstatus");
        $responseClasses = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses");

        // dd($responseClasses->body());
        // dd($responseClasses->json());

        if (($responseStatus->status() == 403) || ($responseClasses->status() == 403)) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if (($responseStatus->status() == 200) && ($responseClasses->status() == 200)) {
            $breadcrumbs = [
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "/quizzes/create", 'name' => "Create Quiz"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.quizzes.create', compact(['responseStatus', 'responseClasses', 'breadcrumbs', 'pageConfigs']));
        } else {
            $response = "You do not have permission for this action";
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "/quizzes/create", 'name' => "Create Quiz"],
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
            'title' => 'required|min:3|max:255',
            'class' => 'required',
            'duration' => 'required|numeric|min:1',
            'noqScq' => 'required|numeric|min:1',
            'noqBq' => 'required|numeric|min:1',
            'noqTheory' => 'required|numeric|min:1',
            'status' => 'required',
        ];

        $custom_messages = [
            'title.required' => 'Quiz Title is required',
            'class.required' => 'Select a class for which the quiz belong',
            'duration.required' => 'Quiz must have a valid duration',
            'duration.numeric' => 'Quiz must have a numeric value',
            'duration.min' => 'Quiz must have a minimum of 1 minute',
            'noqScq.required' => 'Number of Questions is required',
            'noqScq.numeric' => 'Number of Questions must have a numeric value',
            'noqScq.min' => 'Students must answer a minimum of 1 questions',
            'noqBq.required' => 'Number of Questions is required',
            'noqBq.numeric' => 'Number of Questions must have a numeric value',
            'noqBq.min' => 'Students must answer a minimum of 1 questions',
            'noqTheory.required' => 'Number of Questions is required',
            'noqTheory.numeric' => 'Number of Questions must have a numeric value',
            'noqTheory.min' => 'Students must answer a minimum of 1 questions',
            
            'status.required' => 'Quiz status is required',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $user_id = session()->get('user_id');

        $data = [
            'title' => $request->title,
            'class' => $request->class,
            'duration' => +$request->duration,
            'noqScq' => +$request->noqScq,
            'noqBq' => +$request->noqBq,
            'noqTheory' => +$request->noqTheory,
            'status' => $request->status,
            'createdBy' => $user_id,
        ];
        // dd($data);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->POST('https://us-central1-mlms-ec62a.cloudfunctions.net/quizzes', $data);
        // dd($response->status());

        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }
        if ($response->status() == 201 && $response->successful() == true) {
            return redirect('/quizzes')->with('success', "Quiz details has been created");
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "/quizzes/create", 'name' => "Create Quiz"],
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
    public function show($quizId, $classId)
    {
        // dd($quizId);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/quizzes/' . $quizId);
        $responseClass = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses/' . $classId);
        $scqCount = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/questionsObj/count/' . $quizId);
        $bqCount = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/questionsBq/count/' . $quizId);
        $theoryCount = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/questionsTheory/count/' . $quizId);
        // $responseReTypes = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/resourcetypes');
        // dd($bqCount->json());

        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }
        if (($response->json() != null && $response->status() == 200)) {
            $quizDetails = json_decode($response);
            $classDetails = json_decode($responseClass);
            $scqCount = json_decode($scqCount);
            $bqCount = json_decode($bqCount);
            $theoryCount = json_decode($theoryCount);
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "/quizzes/view/$quizId/$classId", 'name' => "View Quiz"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.quizzes.view', compact(['quizDetails', 'classDetails', 'scqCount', 'bqCount', 'theoryCount', 'quizId', 'classId', 'breadcrumbs', 'pageConfigs']));
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "/quizzes/view/$quizId", 'name' => "View Quiz"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.page404', compact(['breadcrumbs', 'pageConfigs']));
        }
    }

    public function showScq($quizId, $classId)
    {
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/quizzes/' . $quizId);
        $responseClass = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses/' . $classId);
        $responseStatus = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/defaultstatus');
        $responseQuestionScq = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/questionsObj/' . $quizId);
        // dd($responseQuestionScq->json());

        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }
        if (($response->json() != null) && ($response->status() == 200) && ($responseClass->json() != null) && ($responseClass->status() == 200)) {
            $quizDetails = json_decode($response);
            $classDetails = json_decode($responseClass);
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "/quizzes/view/$quizId/$classId", 'name' => "View Quiz"],
                ['link' => "/quizzes/viewscq/$quizId/$classId", 'name' => "View Single Choice Questions"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.quizzes.scq', compact(['responseQuestionScq', 'quizDetails', 'classDetails', 'responseStatus', 'quizId', 'classId', 'breadcrumbs', 'pageConfigs']));
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "/quizzes/view/$quizId", 'name' => "View Quiz"],
                ['link' => "/quizzes/viewscq/$quizId/$classId", 'name' => "View Single Choice Questions"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.page404', compact(['breadcrumbs', 'pageConfigs']));
        }
    }

    public function showBq($quizId, $classId)
    {
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/quizzes/' . $quizId);
        $responseClass = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses/' . $classId);
        $responseStatus = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/defaultstatus');
        $responseQuestionBq = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/questionsBq/' . $quizId);
        // dd($responseQuestionBq->json());

        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }
        if (($response->json() != null) && ($response->status() == 200) && ($responseClass->json() != null) && ($responseClass->status() == 200)) {
            $quizDetails = json_decode($response);
            $classDetails = json_decode($responseClass);
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "/quizzes/view/$quizId/$classId", 'name' => "View Quiz"],
                ['link' => "#", 'name' => "View Binary Questions (True/False)"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.quizzes.bq', compact(['responseQuestionBq', 'quizDetails', 'classDetails', 'responseStatus', 'quizId', 'classId', 'breadcrumbs', 'pageConfigs']));
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "/quizzes/view/$quizId", 'name' => "View Quiz"],
                ['link' => "/quizzes/viewbq/$quizId/$classId", 'name' => "View Binary Questions (True/False)"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.page404', compact(['breadcrumbs', 'pageConfigs']));
        }
    }

    public function showTheory($quizId, $classId)
    {
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/quizzes/' . $quizId);
        $responseClass = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses/' . $classId);
        $responseStatus = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/defaultstatus');
        $responseQuestionTheory = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/questionsTheory/' . $quizId);
        // dd($responseQuestionTheory->json());

        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }
        if (($response->json() != null) && ($response->status() == 200) && ($responseClass->json() != null) && ($responseClass->status() == 200)) {
            $quizDetails = json_decode($response);
            $classDetails = json_decode($responseClass);
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "/quizzes/view/$quizId/$classId", 'name' => "View Quiz"],
                ['link' => "#", 'name' => "View Theory"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.quizzes.theory', compact(['responseQuestionTheory', 'quizDetails', 'classDetails', 'responseStatus', 'quizId', 'classId', 'breadcrumbs', 'pageConfigs']));
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "/quizzes/view/$quizId", 'name' => "View Quiz"],
                ['link' => "/quizzes/viewbq/$quizId/$classId", 'name' => "View Theory"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.page404', compact(['breadcrumbs', 'pageConfigs']));
        }
    }

    public function storeScq(Request $request)
    {
        // dd($request);
        $rules = [
            'quizId' => 'required|min:2',
            'classId' => 'required|min:2',
            'question' => 'required|min:2',
            'optionA' => 'required|min:1',
            'optionB' => 'required|min:1',
            'optionC' => 'required|min:1',
            'optionD' => 'required|min:1',
            'answer' => 'required|in:A,B,C,D',
            'status' => 'required',

        ];
        $custom_messages = [
            'quizId.required' => 'Quiz ID is required',
            'quizId.min' => 'Quiz ID must have a minimum of 2 characters',
            'classId.required' => 'Class ID is required',
            'classId.min' => 'Class ID must have a minimum of 2 characters',
            'question.required' => 'Question is required',
            'question.min' => 'Question must have a minimum of 2 characters',
            'optionA.required' => 'Option A cannot be empty',
            'optionA.min' => 'Option A must have a minimum of 1 character',
            'optionB.required' => 'Option B cannot be empty',
            'optionB.min' => 'Option B must have a minimum of 1 character',
            'optionC.required' => 'Option C cannot be empty',
            'optionC.min' => 'Option C must have a minimum of 1 character',
            'optionD.required' => 'Option D cannot be empty',
            'optionD.min' => 'Option D must have a minimum of 1 character',
            'answer.required' => 'A correct option must be selected',
            'answer.in' => 'Answer value can ONLY be A, B, C, or D',
            'status.required' => 'Question status is required',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $user_id = session()->get('user_id');

        $data = [
            'quizId' => $request->quizId,
            'question' => $request->question,
            'optionA' => $request->optionA,
            'optionB' => $request->optionB,
            'optionC' => $request->optionC,
            'optionD' => $request->optionD,
            'answer' => $request->answer,
            'status' => $request->status,
            'createdBy' => $user_id,
        ];
        // dd($data);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->POST('https://us-central1-mlms-ec62a.cloudfunctions.net/questionsObj', $data);
        // dd($response->status());

        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }
        if ($response->status() == 201 && $response->successful() == true) {
            return redirect("/quizzes/viewscq/$request->quizId/$request->classId")->with('success', "New Single Choice Question has been added");
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes/view/$request->quizId/$request->classId", 'name' => "View Quiz"],
                ['link' => "/quizzes/viewscq/$request->quizId/$request->classId", 'name' => "View Single Choice Questions"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
        }
    }

    public function storeBq(Request $request)
    {
        // dd($request);
        $rules = [
            'quizId' => 'required|min:2',
            'classId' => 'required|min:2',
            'question' => 'required|min:2',
            'answer' => 'required|in:true,false',
            'status' => 'required',

        ];
        $custom_messages = [
            'quizId.required' => 'Quiz ID is required',
            'quizId.min' => 'Quiz ID must have a minimum of 2 characters',
            'classId.required' => 'Class ID is required',
            'classId.min' => 'Class ID must have a minimum of 2 characters',
            'question.required' => 'Question is required',
            'question.min' => 'Question must have a minimum of 2 characters',
            'answer.required' => 'A correct option must be selected',
            'answer.in' => 'Correct Answer value can ONLY be True or False',
            'status.required' => 'Question status is required',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $user_id = session()->get('user_id');

        $data = [
            'quizId' => $request->quizId,
            'question' => $request->question,
            'answer' => $request->answer,
            'status' => $request->status,
            'createdBy' => $user_id,
        ];
        // dd($data);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->POST('https://us-central1-mlms-ec62a.cloudfunctions.net/questionsBq', $data);
        // dd($response->status());

        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }
        if ($response->status() == 201 && $response->successful() == true) {
            return redirect("/quizzes/viewbq/$request->quizId/$request->classId")->with('success', "New Binary Choice Question has been added");
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "/quizzes/view/$quizId", 'name' => "View Quiz"],
                ['link' => "/quizzes/viewbq/$quizId/$classId", 'name' => "View Binary Questions (True/False)"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
        }
    }

    public function storeTheory(Request $request)
    {
        // dd($request);
        $rules = [
            'quizId' => 'required|min:2',
            'classId' => 'required|min:2',
            'question' => 'required|min:2',
            'score' => 'required|numeric|min:1',
            'status' => 'required',

        ];
        $custom_messages = [
            'quizId.required' => 'Quiz ID is required',
            'quizId.min' => 'Quiz ID must have a minimum of 2 characters',
            'classId.required' => 'Class ID is required',
            'classId.min' => 'Class ID must have a minimum of 2 characters',
            'question.required' => 'Question is required',
            'question.min' => 'Question must have a minimum of 2 characters',
            'score.required' => 'Theory score is required',
            'score.numeric' => 'Theory score must have a numeric value',
            'score.min' => 'Theory score should be a minimum of 1 questions',
            'status.required' => 'Question status is required',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $user_id = session()->get('user_id');

        $data = [
            'quizId' => $request->quizId,
            'question' => $request->question,
            'score' => +$request->score,
            'status' => $request->status,
            'createdBy' => $user_id,
        ];
        // dd($data);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->POST('https://us-central1-mlms-ec62a.cloudfunctions.net/questionsTheory', $data);
        // dd($response->status());

        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }
        if ($response->status() == 201 && $response->successful() == true) {
            return redirect("/quizzes/viewtheory/$request->quizId/$request->classId")->with('success', "New Theory Question has been added");
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "/quizzes/view/$quizId", 'name' => "View Quiz"],
                ['link' => "/quizzes/viewtheory/$quizId/$classId", 'name' => "View Thoery Questions"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
        }
    }

    public function showSingleScqQuest($questId, $quizId, $classId)
    {
        // dd($classId);

        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/questionsObj/editscq/' . $questId);
        $responseQuizDetails = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/quizzes/' . $quizId);
        $responseClass = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses/' . $classId);
        $responseStatus = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/defaultstatus');
        // $responseQuestionScq = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/questionsObj/'.$quizId);
        // dd($response->json());

        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }
        if (($response->json() != null) && ($response->status() == 200) && ($responseQuizDetails->json() != null) && ($responseQuizDetails->status() == 200)) {
            $quizDetails = json_decode($responseQuizDetails);
            $singleScqDetails = json_decode($response);
            $classDetails = json_decode($responseClass);
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "/quizzes/view/$quizId/$classId", 'name' => "View Quiz"],
                ['link' => "/quizzes/viewscq/$quizId/$classId", 'name' => "View Single Choice Questions"],
                ['link' => "#", 'name' => "Edit Single Choice Questions"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.quizzes.edit-scq', compact(['singleScqDetails', 'quizDetails', 'classDetails', 'responseStatus', 'questId', 'quizId', 'classId', 'breadcrumbs', 'pageConfigs']));
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "/quizzes/view/$quizId", 'name' => "View Quiz"],
                ['link' => "/quizzes/viewscq/$quizId/$classId", 'name' => "View Single Choice Questions"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.page404', compact(['breadcrumbs', 'pageConfigs']));
        }
    }

    public function showSingleBqQuest($questId, $quizId, $classId)
    {
        // dd($questId);

        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/questionsBq/editbq/' . $questId);
        $responseQuizDetails = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/quizzes/' . $quizId);
        $responseClass = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses/' . $classId);
        $responseStatus = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/defaultstatus');
        // $responseQuestionScq = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/questionsObj/'.$quizId);
        // dd($response->json());

        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }
        if (($response->json() != null) && ($response->status() == 200) && ($responseQuizDetails->json() != null) && ($responseQuizDetails->status() == 200)) {
            $quizDetails = json_decode($responseQuizDetails);
            $singleBqDetails = json_decode($response);
            $classDetails = json_decode($responseClass);
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "/quizzes/view/$quizId/$classId", 'name' => "View Quiz"],
                ['link' => "/quizzes/viewbq/$quizId/$classId", 'name' => "View Binary Questions (True/False)"],
                ['link' => "#", 'name' => "Edit Binary Choice Questions"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.quizzes.edit-bq', compact(['singleBqDetails', 'quizDetails', 'classDetails', 'responseStatus', 'questId', 'quizId', 'classId', 'breadcrumbs', 'pageConfigs']));
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "/quizzes/view/$quizId", 'name' => "View Quiz"],
                ['link' => "/quizzes/viewbq/$quizId/$classId", 'name' => "View Binary Questions (True/False)"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.page404', compact(['breadcrumbs', 'pageConfigs']));
        }
    }

    public function showSingleTheoryQuest($questId, $quizId, $classId)
    {
        // dd($questId);

        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/questionsTheory/edittheory/' . $questId);
        $responseQuizDetails = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/quizzes/' . $quizId);
        $responseClass = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses/' . $classId);
        $responseStatus = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/defaultstatus');
        // $responseQuestionScq = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/questionsObj/'.$quizId);
        // dd($response->json());

        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }
        if (($response->json() != null) && ($response->status() == 200) && ($responseQuizDetails->json() != null) && ($responseQuizDetails->status() == 200)) {
            $quizDetails = json_decode($responseQuizDetails);
            $singleTheoryDetails = json_decode($response);
            $classDetails = json_decode($responseClass);
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "/quizzes/view/$quizId/$classId", 'name' => "View Quiz"],
                ['link' => "/quizzes/viewtheory/$quizId/$classId", 'name' => "Therory Question"],
                ['link' => "#", 'name' => "Edit Binary Choice Questions"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.quizzes.edit-theory', compact(['singleTheoryDetails', 'quizDetails', 'classDetails', 'responseStatus', 'questId', 'quizId', 'classId', 'breadcrumbs', 'pageConfigs']));
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "/quizzes/view/$quizId", 'name' => "View Quiz"],
                ['link' => "/quizzes/viewbq/$quizId/$classId", 'name' => "Edit Theory Question"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.page404', compact(['breadcrumbs', 'pageConfigs']));
        }
    }

    public function updateSingleScqQuest(Request $request, $id)
    {
        // dd($request);
        $rules = [
            'quizId' => 'required|min:2',
            'classId' => 'required|min:2',
            'questId' => 'required|min:2',
            'question' => 'required|min:2',
            'optionA' => 'required|min:1',
            'optionB' => 'required|min:1',
            'optionC' => 'required|min:1',
            'optionD' => 'required|min:1',
            'answer' => 'required|in:A,B,C,D',
            'status' => 'required',

        ];
        $custom_messages = [
            'quizId.required' => 'Quiz ID is required',
            'quizId.min' => 'Quiz ID must have a minimum of 2 characters',
            'classId.required' => 'Class ID is required',
            'classId.min' => 'Class ID must have a minimum of 2 characters',
            'questId.required' => 'Question ID is required',
            'questId.min' => 'Question ID must have a minimum of 2 characters',
            'question.required' => 'Question is required',
            'question.min' => 'Question must have a minimum of 2 characters',
            'optionA.required' => 'Option A cannot be empty',
            'optionA.min' => 'Option A must have a minimum of 1 character',
            'optionB.required' => 'Option B cannot be empty',
            'optionB.min' => 'Option B must have a minimum of 1 character',
            'optionC.required' => 'Option C cannot be empty',
            'optionC.min' => 'Option C must have a minimum of 1 character',
            'optionD.required' => 'Option D cannot be empty',
            'optionD.min' => 'Option D must have a minimum of 1 character',
            'answer.required' => 'A correct option must be selected',
            'answer.in' => 'Answer value can ONLY be A, B, C, or D',
            'status.required' => 'Question status is required',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $user_id = session()->get('user_id');

        $data = [
            'question' => $request->question,
            'optionA' => $request->optionA,
            'optionB' => $request->optionB,
            'optionC' => $request->optionC,
            'optionD' => $request->optionD,
            'answer' => $request->answer,
            'status' => $request->status,
            'updatedBy' => $user_id,
        ];
        // dd($data);

        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->PATCH('https://us-central1-mlms-ec62a.cloudfunctions.net/questionsObj/' . $id, $data);
        //  dd($response->status());

        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 201 && $response->successful() == true) {
            // return redirect('/quizzes')->with('success', "Quiz Details has been updated");
            return redirect("/quizzes/viewscq/$request->quizId/$request->classId")->with('success', "Selected question has been updated");
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "/quizzes/view/$request->quizId/$request->classId", 'name' => "View Quiz"],
                ['link' => "/quizzes/viewscq/$request->quizId/$request->classId", 'name' => "View Single Choice Questions"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
        }

    }

    public function updateSingleBqQuest(Request $request, $id)
    {
        // dd($request);
        $rules = [
            'quizId' => 'required|min:2',
            'classId' => 'required|min:2',
            'question' => 'required|min:2',
            'answer' => 'required|in:true,false',
            'status' => 'required',

        ];
        $custom_messages = [
            'quizId.required' => 'Quiz ID is required',
            'quizId.min' => 'Quiz ID must have a minimum of 2 characters',
            'classId.required' => 'Class ID is required',
            'classId.min' => 'Class ID must have a minimum of 2 characters',
            'question.required' => 'Question is required',
            'question.min' => 'Question must have a minimum of 2 characters',
            'answer.required' => 'A correct option must be selected',
            'answer.in' => 'Correct Answer value can ONLY be True or False',
            'status.required' => 'Question status is required',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $user_id = session()->get('user_id');

        $data = [
            'quizId' => $request->quizId,
            'question' => $request->question,
            'answer' => $request->answer,
            'status' => $request->status,
            'updatedBy' => $user_id,
        ];
        // dd($data);

        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->PATCH('https://us-central1-mlms-ec62a.cloudfunctions.net/questionsBq/' . $id, $data);
        //  dd($response->status());

        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 201 && $response->successful() == true) {
            // return redirect('/quizzes')->with('success', "Quiz Details has been updated");
            return redirect("/quizzes/viewbq/$request->quizId/$request->classId")->with('success', "Selected question has been updated");
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "/quizzes/view/$request->quizId/$request->classId", 'name' => "View Quiz"],
                ['link' => "/quizzes/viewbq/$request->quizId/$request->classId", 'name' => "View Binary Questions (True/False)"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
        }

    }

    public function updateSingleTheoryQuest(Request $request, $id)
    {
        // dd($request);
        $rules = [
            'quizId' => 'required|min:2',
            'classId' => 'required|min:2',
            'question' => 'required|min:2',
            'score' => 'required|numeric|min:1',
            'status' => 'required',

        ];
        $custom_messages = [
            'quizId.required' => 'Quiz ID is required',
            'quizId.min' => 'Quiz ID must have a minimum of 2 characters',
            'classId.required' => 'Class ID is required',
            'classId.min' => 'Class ID must have a minimum of 2 characters',
            'question.required' => 'Question is required',
            'question.min' => 'Question must have a minimum of 2 characters',
            'score.required' => 'Theory score is required',
            'score.numeric' => 'Theory score must have a numeric value',
            'score.min' => 'Theory score should be a minimum of 1 questions',
            'status.required' => 'Question status is required',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $user_id = session()->get('user_id');

        $data = [
            'question' => $request->question,
            'score' => +$request->score,
            'status' => $request->status,
            'updatedBy' => $user_id,
        ];
        // dd($data);

        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->PATCH('https://us-central1-mlms-ec62a.cloudfunctions.net/questionsTheory/' . $id, $data);
        //  dd($response->status());

        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 201 && $response->successful() == true) {
            // return redirect('/quizzes')->with('success', "Quiz Details has been updated");
            return redirect("/quizzes/viewtheory/$request->quizId/$request->classId")->with('success', "Selected question has been updated");
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "/quizzes/view/$request->quizId/$request->classId", 'name' => "View Quiz"],
                ['link' => "/quizzes/viewtheory/$request->quizId/$request->classId", 'name' => "View Theory"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
        }

    }

    public function deleteSingleScqQuest($questId, $classId, $quizId)
    {
        // dd($quizId);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->DELETE('https://us-central1-mlms-ec62a.cloudfunctions.net/questionsObj/' . $questId);
        // dd($response);
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 200 && $response->successful() == true) {
            return redirect("/quizzes/viewscq/$quizId/$classId")->with('success', "Question successfully deleted");
            // return back()->withSuccess($validator->success("Question successfully deleted"));
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "/quizzes/view/$quizId/$classId", 'name' => "View Quiz"],
                ['link' => "/quizzes/viewscq/$quizId/$classId", 'name' => "View Single Choice Questions"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
        }
    }

    public function deleteSingleBqQuest($questId, $classId, $quizId)
    {
        // dd($quizId);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->DELETE('https://us-central1-mlms-ec62a.cloudfunctions.net/questionsBq/' . $questId);
        // dd($response);
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 200 && $response->successful() == true) {
            return redirect("/quizzes/viewbq/$quizId/$classId")->with('success', "Question successfully deleted");
            // return back()->withSuccess($validator->success("Question successfully deleted"));
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "/quizzes/view/$quizId/$classId", 'name' => "View Quiz"],
                ['link' => "/quizzes/viewbq/$quizId/$classId", 'name' => "View Binary Questions (True/False)"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
        }
    }
  
    public function deleteSingleTheoryQuest($questId, $classId, $quizId)
    {
        // dd($quizId);
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->DELETE('https://us-central1-mlms-ec62a.cloudfunctions.net/questionsTheory/' . $questId);
        // dd($response);
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 200 && $response->successful() == true) {
            return redirect("/quizzes/viewtheory/$quizId/$classId")->with('success', "Question successfully deleted");
            // return back()->withSuccess($validator->success("Question successfully deleted"));
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "/quizzes/view/$quizId/$classId", 'name' => "View Quiz"],
                ['link' => "/quizzes/viewtheory/$quizId/$classId", 'name' => "View Theory"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
        }
    }


    public function showAll($quizId)
    {}

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
            'title' => 'required|min:3|max:255',
            'class' => 'required',
            'duration' => 'required|numeric|min:1',
            'noqScq' => 'required|numeric|min:1',
            'noqBq' => 'required|numeric|min:1',
            'noqTheory' => 'required|numeric|min:1',
            'status' => 'required',
        ];

        $custom_messages = [
            'title.required' => 'Quiz Title is required',
            'class.required' => 'Select a class for which the quiz belong',
            'duration.required' => 'Quiz must have a valid duration',
            'duration.numeric' => 'Quiz must have a numeric value',
            'duration.min' => 'Quiz must have a minimum of 1 minute',
            'noqScq.required' => 'Number of Questions is required',
            'noqScq.numeric' => 'Number of Questions must have a numeric value',
            'noqScq.min' => 'Students must answer a minimum of 1 questions',
            'noqBq.required' => 'Number of Questions is required',
            'noqBq.numeric' => 'Number of Questions must have a numeric value',
            'noqBq.min' => 'Students must answer a minimum of 1 questions',
            'noqTheory.required' => 'Number of Questions is required',
            'noqTheory.numeric' => 'Number of Questions must have a numeric value',
            'noqTheory.min' => 'Students must answer a minimum of 1 questions',
            'status.required' => 'Quiz status is required',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $user_id = session()->get('user_id');

        $data = [
            'title' => $request->title,
            'class' => $request->class,
            'duration' => +$request->duration,
            'noqScq' => +$request->noqScq,
            'noqBq' => +$request->noqBq,
            'noqTheory' => +$request->noqTheory,
            'status' => $request->status,
            'updatedBy' => $user_id,
        ];
        // dd($data);

        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->PATCH('https://us-central1-mlms-ec62a.cloudfunctions.net/quizzes/' . $id, $data);
        //  dd($response->status());

        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }
        if ($response->status() == 201 && $response->successful() == true) {
            return redirect('/quizzes')->with('success', "Quiz Details has been updated");
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "/quizzes/create", 'name' => "Create Quiz"],
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
        $response = Http::withToken($id_token)->DELETE('https://us-central1-mlms-ec62a.cloudfunctions.net/quizzes/' . $id);
        // dd($response);
        if ($response->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($response->status() == 200 && $response->successful() == true) {
            return redirect('/quizzes')->with('success', "Quiz and Its Details successfully deleted");
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/quizzes", 'name' => "Quizzes"],
                ['link' => "#", 'name' => "404 Page"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
        }
    }
}
