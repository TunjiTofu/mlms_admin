<?php
namespace App\Classes;

// use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class SignUpClass
{

    protected $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function signup($email, $password)
    {

        // $client = new Client();

        // Create a POST request using google api

        $key = $this->apiKey;
        $data = [
            'email' => $email,
            'password' => $password,
            'returnSecureToken' => true,
        ];

        // dd($data);
        $response = Http::POST('https://identitytoolkit.googleapis.com/v1/accounts:signUp?key=' . $key, $data);

        $body = json_decode($response->getBody());
        // $js = json_decode($body);

        if (isset($body->error)) {
            return [
                'success' => false,
                'message' => $body->error->message,
            ];
        } else {
            return [
                'success' => true,
                'localId' => $body->localId,
                'idToken' => $body->idToken,
                'email' => $body->email,
                'refreshToken' => $body->refreshToken,
                'expiresIn' => $body->expiresIn,
            ];

        }

    }

}
