<?php

namespace App\Http\Controllers;

/**
 * Class CommonController
 * @package App\Http\Controllers
 */
class CommonController extends Controller
{
    public function healthcheck()
    {
        header('Content-type:text/plain');
        echo 'OK';
        exit(0);
    }
}
