<?php

namespace App\Http;

/**
 * Class Response
 * @package App\Http
 */
class Response
{
    /** @var array $data */
    public $data = [];

    /** @var array $pagination */
    public $pagination = [];

    /** @var array $sorting */
    public $sorting = [];

    /** @var array $search */
    public $search = [];

    /** @var array $error */
    public $error = [];
}
