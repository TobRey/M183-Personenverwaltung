<?php

namespace App\Gateways;

class TypeGateway extends BasicTableGateway
{
    protected $table = "type";
    protected $fields = [
        'id' => 'i',
        'label' => 's'
    ];
}
