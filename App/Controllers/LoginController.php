<?php

namespace App\Controllers;

use App\Models\User;
use App\Utils\JWTService;
use Carbon\Carbon;

class LoginController extends DefaultController
{
    public function login(array $data)
    {
        $returnValue = null;
        $user = User::findByEmail($data['email']);

        if ($user) {

            if (password_verify($data['password'], $user->getPassword())) {

                $header = [
                    'alg' => 'HS256',
                    'typ' => 'JWT'
                ];

                $now = Carbon::now();

                $payload = [
                    'sub' => "User-{$user->getId()}",
                    'name' => "{$user->getFirstname()} {$user->getLastname()}",
                    'iat' => $now->timestamp,
                    'exp' => $now->addDays(30)->timestamp
                ];

                $user->setToken(JWTService::generateJWT($header, $payload));
                $returnValue = json_encode($user, JSON_UNESCAPED_UNICODE);
            }
        }

        echo $returnValue;
    }
}
