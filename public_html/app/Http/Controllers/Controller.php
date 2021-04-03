<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
    * @OA\Info(
    *   title="Your Awesome Modules's API",
    *  version="2.0.0",
    *  @OA\Contact(
    *    email="developers@module.com",
    *    name="Developer Team"
    *  )
    * )
    */

    /**
     * @OA\SecurityScheme(
     *   securityScheme="token",
     *   type="apiKey",
     *   name="Authorization",
     *   in="header"
     * )
     */
}
