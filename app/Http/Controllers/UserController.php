<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{


    /**
     * @SWG\Post(
     *     path="/api/register",
     *     tags={"Auth"},
     *     summary="register new user",
     *     @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Data for user registration",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/RegisterUserRequest")
     *   ),
     *     @SWG\Response(
     *          response=200,
     *          description="success",
     *     @SWG\Schema(ref="#/definitions/RegisterUserResponse")
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

    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $hasher = app()->make('hash');
        $email = $request->input('email');
        $password = $hasher->make($request->input('password'));
        $user = User::create([
            'email' => $email,
            'password' => $password,
        ]);

        $res['success'] = true;
        $res['message'] = 'Success register!';
        $res['id'] = $user->id;
        return response()->json($res, 200);
    }
}
