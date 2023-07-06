<?php

namespace App\Controllers;

use App\Models\Type;

class TypeController extends DefaultController
{
    public function get()
    {
        echo json_encode(Type::all());
    }
}
