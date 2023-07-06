<?php

namespace App\Middleware;

use App\Utils\JWTService;

class Authenticated
{
    public function handle(): bool
    {
        $token = null;
        if (array_key_exists("HTTP_AUTHORIZATION", $_SERVER)) {
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
            if (!empty($headers)) {
                if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                    $token = $matches[1];
                }
            }
        }

        if (!$token) {
            return false;
        } else {
            return JWTService::isJWTValid($token);
        }
    }
}

/*
if (isset($_SERVER['Authorization'])) {
		$headers = trim($_SERVER["Authorization"]);
	} else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
		$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
	} else if (function_exists('apache_request_headers')) {
		$requestHeaders = apache_request_headers();
		// Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
		$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
		if (isset($requestHeaders['Authorization'])) {
			$headers = trim($requestHeaders['Authorization']);
		}
	}
*/