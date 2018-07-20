<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @SWG\Swagger(
     *     basePath="/",
     *     host=API_HOST,
     *     schemes=API_SCHEMES,
     *     produces={"application/json"},
     *     consumes={"application/json"},
     *          @SWG\Info(
     *              title="CherryPick Swagger",
     *              version="1.0",
     *              description="human-readable documentation for API.",
     *          ),
     * )
     */
}
