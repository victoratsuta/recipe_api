<?php

namespace App\Http\Controllers;


use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RecipeController extends Controller
{

    /**
     * @SWG\Get(
     *     path="/api/recipe/{id}",
     *     tags={"Recipe"},
     *     summary="Get recipe",
     *     @SWG\Parameter(
     *     in="path",
     *     type="integer",
     *     name="id",
     *     description="id of recipe",
     *   ),
     *     @SWG\Parameter(
     *     in="query",
     *     type="string",
     *     name="token",
     *     description="token for auth",
     *   ),
     *     @SWG\Response(
     *          response=200,
     *          description="success",
     *     @SWG\Schema(ref="#/definitions/Recipe")
     *      ),
     *     @SWG\Response(
     *          response="422",
     *          description="Error Validation",
     *   ),
     *     @SWG\Response(
     *          response=401,
     *          description="Unauthorized",
     *      )
     * ),
     */

    public function get($id)
    {

        $recipe = Recipe
            ::with('ingredients')
            ->where('id', $id)
            ->first();

        $recipe->image = Recipe::URL_TO_IMAGE . $recipe->image;

        return response
        (
            $recipe->toArray(),
            200
        );

    }

    /**
     * @SWG\Post(
     *     path="/api/recipe",
     *     tags={"Recipe"},
     *     summary="Create recipe",
     *     @SWG\Parameter(
     *     in="query",
     *     type="string",
     *     name="token",
     *     description="token for auth",
     *   ),
     *     @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="params for recipe",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/RecipeCreate")
     *   ),
     *     @SWG\Response(
     *          response=200,
     *          description="success",
     *     @SWG\Schema(ref="#/definitions/IdResponse")
     *      ),
     *     @SWG\Response(
     *          response="422",
     *          description="Error Validation",
     *   ),
     *     @SWG\Response(
     *          response=401,
     *          description="Unauthorized",
     *      )
     * ),
     */

    public function store(Request $request)
    {

        $this->validateRecipe($request);

        $recipe = Recipe::create(
            [
                'name' => $request->get('name')
            ]
        );

        foreach ($request->get('ingredients') as $ingredient) {

            Ingredient::create(
                [
                    'recipe_id' => $recipe->id,
                    'name' => $ingredient['name']
                ]
            );

        }

        return response()->json($recipe->id, 200);

    }

    /**
     * @SWG\Put(
     *     path="/api/recipe/{id}",
     *     tags={"Recipe"},
     *     summary="Update recipe",
     *     @SWG\Parameter(
     *     in="path",
     *     type="string",
     *     name="id",
     *     description="Id of recipe",
     *   ),
     *     @SWG\Parameter(
     *     in="query",
     *     type="string",
     *     name="token",
     *     description="token for auth",
     *   ),
     *     @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="params for recipe",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/RecipeCreate")
     *   ),
     *     @SWG\Response(
     *          response=200,
     *          description="success",
     *     @SWG\Schema(ref="#/definitions/IdResponse")
     *      ),
     *     @SWG\Response(
     *          response="422",
     *          description="Error Validation",
     *   ),
     *     @SWG\Response(
     *          response=401,
     *          description="Unauthorized",
     *      )
     * ),
     */

    public function update(Request $request, $id)
    {

        $this->validateRecipe($request);

        $recipe = Recipe::findOrFail($id);

        $recipe->update(
            [
                'name' => $request->get('name')
            ]
        );

        $recipe->removeOldIngredients();


        foreach ($request->get('ingredients') as $ingredient) {

            Ingredient::create(
                [
                    'recipe_id' => $recipe->id,
                    'name' => $ingredient['name']
                ]
            );

        }

        return response()->json($recipe->id, 200);

    }

    /**
     * @SWG\Delete(
     *     path="/api/recipe/{id}",
     *     tags={"Recipe"},
     *     summary="Recipe delete",
     *     @SWG\Parameter(
     *     in="query",
     *     type="string",
     *     name="token",
     *     description="token for auth",
     *   ),
     *     @SWG\Parameter(
     *            name="id",
     *            in="path",
     *            type="integer",
     *            description="Id of Recipe"
     *        ),
     *     @SWG\Response(
     *          response=200,
     *          description="success",
     *      ),
     *     @SWG\Response(
     *          response="404",
     *          description="candidateId not found",
     *   ),
     *     @SWG\Response(
     *          response=401,
     *          description="Unauthorized",
     *      )
     * ),
     */

    public function delete($id)
    {

        $recipe = Recipe::findOrFail($id);

        $recipe->removeOldIngredients();

        unlink(storage_path(Recipe::PATH_TO_IMAGE . $recipe->image));

        $recipe->delete();

    }

    /**
     * @SWG\Post(
     *     path="/api/recipe/image/{id}",
     *     tags={"Recipe"},
     *     summary="Create recipe json",
     *     @SWG\Parameter(
     *     in="path",
     *     type="string",
     *     name="id",
     *     description="Id of recipe",
     *   ),
     *     @SWG\Parameter(
     *     in="query",
     *     type="string",
     *     name="token",
     *     description="token for auth",
     *   ),
     *     @SWG\Parameter(
     *            name="image",
     *            in="formData",
     *            type="file",
     *            description="Id of candidate"
     *        ),
     *
     *     @SWG\Response(
     *          response=200,
     *          description="success"
     *      ),
     *     @SWG\Response(
     *          response="422",
     *          description="Error Validation",
     *   ),
     *     @SWG\Response(
     *          response=401,
     *          description="Unauthorized",
     *      )
     * ),
     */

    public function imageUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            [
                'image' => 'required|image|mimes:jpg,jpeg,png|max:10240'
            ]
        );

        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);

        }


        $recipe = Recipe::findOrFail($id);

        if ($request->hasFile('image')) {

            $recipe->saveImage($request->file('image'));

        }

    }

    public function validateRecipe(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'name' => 'required|string',
                'ingredients' => 'required|array',
                'ingredients.*.name' => 'required|string'
            ]
        );

        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);

        }

    }

}
