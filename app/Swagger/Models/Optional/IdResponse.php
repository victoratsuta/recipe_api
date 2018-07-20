<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 13.06.18
 * Time: 17:32
 */

namespace App\Http\Controllers\Swagger\Optional;

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="IdResponse"))
 */

class IdResponse
{
    /**
     * @SWG\Property()
     * @var integer
     */
    public $id;
}
