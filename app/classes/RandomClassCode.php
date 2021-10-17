<?php
namespace App\Classes;

// use GuzzleHttp\Client;
// use Illuminate\Support\Facades\Http;

class RandomClassCode
{

    public function generateRandomString($length) {
        $characters = '$!<>@#0123456789abcdeghjknopqrsuvwxyzABCDEGHIJKLNOPQRSUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
