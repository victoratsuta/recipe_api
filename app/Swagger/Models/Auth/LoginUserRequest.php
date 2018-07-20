<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 20.07.18
 * Time: 16:16
 */

namespace App\Swagger\Models;

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="LoginUserRequest"))
 */

class LoginUserRequest
{

    /**
     * @var string
     * @SWG\Property(example="example@gamil.com")
     */
    public $email;

    /**
     * @var string
     * @SWG\Property()
     */
    public $password;

}