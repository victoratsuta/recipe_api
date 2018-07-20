<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 20.07.18
 * Time: 17:15
 */

namespace App\Swagger\Models\Recipe;

use App\Swagger\Models\Ingredient\Ingredient;

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="Recipe"))
 */

class Recipe
{
    /**
     * @var string
     * @SWG\Property(example="Pizza")
     */
    public $name;

    /**
     * @var string
     * @SWG\Property()
     */
    public $image;

    /**
     * @var Ingredient[]
     * @SWG\Property()
     */
    public $ingredients;

}