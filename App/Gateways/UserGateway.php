<?php

namespace App\Gateways;

class UserGateway extends BasicTableGateway
{
    protected $table = "user";
    protected $fields = [
        'id' => 'i',
        'firstname' => 's',
        'lastname' => 's',
        'email' => 's',
        'password' => 's'
    ];
}
