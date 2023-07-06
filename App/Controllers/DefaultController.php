<?php

namespace App\Controllers;

use App\Utils\Validator;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class DefaultController
{
    private Environment $twig;
    protected Validator $validator;

    public function __construct()
    {
        $loader = new FilesystemLoader('resources/views');
        $this->twig = new Environment($loader);
        $this->validator = new Validator();
    }


    protected function validate($params, $rules)
    {
        $response = $this->validator->validate($params, $rules);
        if ($response) {
            http_response_code(422);
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            die();
        }

        return true;
    }
}
