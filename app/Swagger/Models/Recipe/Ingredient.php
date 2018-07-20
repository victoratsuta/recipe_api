<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 20.07.18
 * Time: 17:17
 */

namespace App\Swagger\Models\Ingredient;

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="Ingredient"))
 */

class Ingredient
{

    /**
     * @var string
     * @SWG\Property(example="cheese")
     */
    public $name;

}