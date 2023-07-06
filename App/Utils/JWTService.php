<?php

namespace App\Utils;

use Carbon\Carbon;

class JWTService
{
    public static function generateJWT(array $header, array $payload, string $secret = 'secret'): string
    {
        $header64 = self::base64UrlEncode(json_encode($header));
        $payload64 = self::base64UrlEncode(json_encode($payload));

        $signature = hash_hmac('SHA256', "$header64.$payload64", $secret, true);
        $signature64 = self::base64UrlEncode($signature);

        return "$header64.$payload64.$signature64";
    }

    private static function base64UrlEncode(string $data): string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }

    public static function isJWTValid($jwt, $secret = 'secret')
    {
        $tokenParts = explode('.', $jwt);
        $header = base64_decode($tokenParts[0]);
        $payload = base64_decode($tokenParts[1]);
        $providedSignature = $tokenParts[2];

        $expirationTimestamp = json_decode($payload)->exp; // !!!

        $now = Carbon::now();
        $expiration = new Carbon($expirationTimestamp);
        $diffInDays = $expiration->diff($now)->days;
        $tokenExpired = $diffInDays <= 0;

        $base64Header = self::base64UrlEncode($header);
        $base64Payload = self::base64UrlEncode($payload);
        $signature = hash_hmac('SHA256', "$base64Header.$base64Payload", $secret, true);
        $base64Signature = self::base64UrlEncode($signature);

        $signatureValid = ($base64Signature === $providedSignature);

        return $signatureValid && !$tokenExpired;
    }
}
