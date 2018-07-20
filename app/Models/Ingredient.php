<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 18.07.18
 * Time: 14:10
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $guarded = ['id'];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

}