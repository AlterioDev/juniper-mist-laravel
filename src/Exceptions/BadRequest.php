<?php
namespace Basduchambre\JuniperMist\Exceptions;

use Exception;

class BadRequest extends Exception
{
    public $response;

    public function __construct($response)
    {
        $this->response = $response;

        return json_decode($response->getBody(), true);
    }
}
