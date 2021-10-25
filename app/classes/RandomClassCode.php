<?php
namespace App\Classes;

// use GuzzleHttp\Client;
// use Illuminate\Support\Facades\Http;

class RandomClassCode
{

    public function generateRandomString($length) {
        $characters = '$!<>@#0123456789abcdeghjknpqrvwxyzABCDEGHIJKLNOPQRSUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function generateRandomCharResource($length) {
        $characters = '123456789abcdeghijklmnopqrstuvwxyzABCDEGHIJKLNOPQRSUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
