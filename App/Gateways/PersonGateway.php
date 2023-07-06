<?php

namespace App\Gateways;

class PersonGateway extends BasicTableGateway
{
    protected $table = "person";
    protected $fields = [
        'id' => 'i',
        'user_id' => 'i',
        'type_id' => 'i',
        'firstname' => 's',
        'lastname' => 's',
        'completed' => 'i'
    ];
}
