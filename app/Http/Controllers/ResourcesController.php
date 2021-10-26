<?php

namespace App\Http\Controllers;

use App\Classes\RandomClassCode;
use App\Classes\ResourceFileSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ResourcesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_token = session()->get('id_Token');
        // $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminResources');
        // $responseTopics = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminTopics');
        $responseClasses = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/adminClasses");
        // $responseStatus = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/defaultstatus");
        // $responseModules = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/adminModules");
        // dd($responseClasses->json());
        if ($responseClasses->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if ($responseClasses->status() == 200 && $responseClasses->ok() == true) {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/resources", 'name' => "Class Resources"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.resources.index', compact(['responseClasses', 'breadcrumbs', 'pageConfigs']));
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/resources", 'name' => "Resources"],
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
        $responseResTypes = Http::withToken($id_token)->GET("https://us-central1-mlms-ec62a.cloudfunctions.net/resourcetypes");
        // dd($response->json());
        if (($responseClasses->status() == 403) || ($responseStatus->status() == 403) || ($responseResTypes->status() == 403)) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if (($responseResTypes->status() == 200 && $responseResTypes->ok() == true) || ($responseClasses->status() == 200 && $responseClasses->ok() == true) || ($responseStatus->status() == 200 && $responseStatus->ok() == true)) {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/resources", 'name' => "Reources"],
                ['link' => "/resources/create", 'name' => "Upload Resources"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.resources.create', compact(['responseClasses', 'responseStatus', 'responseResTypes', 'breadcrumbs', 'pageConfigs']));
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $rules = [
            'resourceTitle' => 'required|min:3|max:255',
            'class' => 'required',
            'resourceType' => 'required',
            'status' => 'required',
            'imagePath' => 'required',
        ];

        $custom_messages = [
            'resourceTitle.required' => 'Resource Title is required',
            'resourceTitle.min' => 'Resource Title must have a minumum of 3 characters',
            'resourceTitle.max' => 'Resource Title can have a maximum of 255 characters',
            'class.required' => 'Class is required',
            'resourceType.required' => 'Resource Type is required',
            'imagePath.min' => 'Image Path must have a minumum of 3 characters',
            'status.required' => 'Status is required',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        //Random code to appen to the title
        $code = new RandomClassCode();
        $randCode = $code->generateRandomCharResource(4);
        // dd($randCode);

        //User ID
        $user_id = session()->get('user_id');

        //New Resource Title
        $titleWithRandCode = $request->resourceTitle . '_' . $randCode;
        $newResTitle = str_replace(' ', '_', $titleWithRandCode);

        //Resource Type
        $resType = $request->resourceType;
        // dd($resType);

        if ($request->hasFile('imagePath')) {
            if ($request->file('imagePath')->isValid()) {
                try {
                    $file = $request->file('imagePath');
                    // dd($file);
                    $extension = $request->file('imagePath')->extension();
                    // dd($extension);
                    $mime = $request->file('imagePath')->getMimeType();
                    // dd($mime);

                    //Get the file of Uploaded Resource
                    $size = new ResourceFileSize();
                    $resSize = $size->humanFileSize($request->file('imagePath')->getSize());
                    // dd($resSize);


                    $resBase64Encode = '';

                    switch ($resType) {
                        case "pics":
                            if ($mime == 'image/jpeg' || $mime == 'image/png') {
                                $resBase64Encode = base64_encode(file_get_contents($request->file('imagePath')));
                            } else {
                                return back()->with('error', "Selected Resource Type and Uploaded Document do not match.\n Upload a \".jpg\" or \".png\" file");
                            }
                            break;
                        case "docx":
                            if (($mime == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') || ($mime == 'application/msword') || ($mime == 'application/doc') || ($mime == 'application/ms-doc')) {
                                $resBase64Encode = base64_encode(file_get_contents($request->file('imagePath')));
                            } else {
                                return back()->with('error', "Selected Resource Type and Uploaded Document do not match. Change the Resource Type or Upload a \".docx\" or \".doc\" file");
                            }
                            break;
                        case "pdf":
                            if ($mime == 'application/pdf') {
                                $resBase64Encode = base64_encode(file_get_contents($request->file('imagePath')));
                            } else {
                                return back()->with('error', "Selected Resource Type and Uploaded Document do not match.\n Upload a \".pdf\" file");
                            }
                            break;
                        case "ppt":
                            if (($mime == 'application/vnd.openxmlformats-officedocument.presentationml.presentation') || ($mime == 'application/x-mspowerpoint') || ($mime == 'application/vnd.ms-powerpoint') || ($mime == 'application/powerpoint') || ($mime == 'application/mspowerpoint')) {
                                $resBase64Encode = base64_encode(file_get_contents($request->file('imagePath')));
                            } else {
                                return back()->with('error', "Selected Resource Type and Uploaded Document do not match.\n Upload a \".pptx\" or \".ppt\" file");
                            }
                            break;

                        case "xlxs":
                            if (($mime == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') || ($mime == 'application/x-msexcel') || ($mime == 'application/vnd.ms-excel') || ($mime == 'application/x-excel') || ($mime == 'application/excel')) {
                                $resBase64Encode = base64_encode(file_get_contents($request->file('imagePath')));
                            } else {
                                return back()->with('error', "Selected Resource Type and Uploaded Document do not match.\n Upload a \".xlsx\" or \".xlx\" file");
                            }
                            break;

                        case "txt":
                            if ($mime == 'text/plain') {
                                $resBase64Encode = base64_encode(file_get_contents($request->file('imagePath')));
                            } else {
                                return back()->with('error', "Selected Resource Type and Uploaded Document do not match.\n Upload a \".txt\" file");
                            }
                            break;

                        case "audio":
                            if (($mime == 'audio/mpeg') || ($mime == 'audio/x-wav')) {
                                $resBase64Encode = base64_encode(file_get_contents($request->file('imagePath')));
                            } else {
                                return back()->with('error', "Selected Resource Type and Uploaded Document do not match.\n Upload a \".mp3\" or \".wav\" file");
                            }
                            break;

                        default:
                            echo "Resource Type Invalid!";
                    }
                    // dd($resBase64Encode);
                } catch (FileNotFoundException $e) {
                    echo "catch";
                }
            }

            $data = [
                'resourceTitle' => $newResTitle,
                'class' => $request->class,
                'resourceType' => $request->resourceType,
                'resourceBase64Encoded' => $resBase64Encode,
                'status' => $request->status,
                'userId' => $user_id,
                'extension' => $mime,
                'size' => $resSize,
            ];
            // dd($data);
            $id_token = session()->get('id_Token');
            $response = Http::withToken($id_token)->POST('https://us-central1-mlms-ec62a.cloudfunctions.net/adminResources', $data);
            // dd($response->status());

            if ($response->status() == 403) {
                return redirect('/login')->with('error', 'Unauthorized - Please login');
            }

            if ($response->status() == 201 && $response->successful() == true) {
                return redirect('/resources')->with('success', "Resource has been added");
            } else {
                $breadcrumbs = [
                    ['link' => "/", 'name' => "Dashboard"],
                    ['link' => "/resources", 'name' => "Resources"],
                    ['link' => "#", 'name' => "404 Page"],
                ];
                $pageConfigs = ['pageHeader' => true];
                return view('pages.error.unauthorized', compact(['response', 'breadcrumbs', 'pageConfigs']));
            }
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
        $classId = $id;
        $id_token = session()->get('id_Token');
        $response = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/adminResources/' . $id);
        $responseReTypes = Http::withToken($id_token)->GET('https://us-central1-mlms-ec62a.cloudfunctions.net/resourcetypes');
        // dd($response->json());

        if ($response->status() == 403 || $responseReTypes->status() == 403) {
            return redirect('/login')->with('error', 'Unauthorized - Please login');
        }

        if (($response->json() != null && $response->status() == 200) || ($responseReTypes->json() != null && $responseReTypes->status() == 200)) {
            // $post = json_decode($response);
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/resources", 'name' => "Class Resources"],
                ['link' => "/resources/view/$id", 'name' => "View All Class Resources"],
            ];
            $pageConfigs = ['pageHeader' => true];
            return view('pages.admin.resources.view', compact(['response', 'responseReTypes', 'classId', 'breadcrumbs', 'pageConfigs']));
        } else {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Dashboard"],
                ['link' => "/resources", 'name' => "Class Resources"],
                ['link' => "/resources/view/$id", 'name' => "View All Class Resources"],
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
