<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 20.07.18
 * Time: 17:15
 */

namespace App\Swagger\Models\RecipeCreate;

use App\Swagger\Models\Ingredient\Ingredient;

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="RecipeCreate"))
 */

class RecipeCreate
{
    /**
     * @var string
     * @SWG\Property(example="Pizza")
     */
    public $name;

    /**
     * @var Ingredient[]
     * @SWG\Property()
     */
    public $ingredients;

}