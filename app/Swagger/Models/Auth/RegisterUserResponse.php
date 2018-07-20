<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 20.07.18
 * Time: 16:16
 */

namespace App\Swagger\Models;

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="RegisterUserResponse"))
 */

class RegisterUserResponse
{


    /**
     * @var boolean
     * @SWG\Property()
     */
    public $success;


    /**
     * @var string
     * @SWG\Property()
     */
    public $message;

    /**
     * @var integer
     * @SWG\Property()
     */
    public $id;

}