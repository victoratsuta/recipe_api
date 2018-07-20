<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 18.07.18
 * Time: 14:10
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $guarded = ['id'];

    const DEFAULT_IMAGE = 'default.jpg';
    const PATH_TO_IMAGE = 'app/public/images/';
    const URL_TO_IMAGE = 'storage/images/';

    public function ingredients(){

        return $this->hasMany(Ingredient::class);

    }

    public function saveImage($image)
    {

        $filename = time() . '.' . $image->getClientOriginalExtension();

        $image->move(storage_path(self::PATH_TO_IMAGE), $filename);


        $this->update(['image' => $filename]);

    }

    public function removeOldIngredients(){

        foreach ($this->ingredients as $ingredient){

            $ingredient->delete();

        }

    }

}