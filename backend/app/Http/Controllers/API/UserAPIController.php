<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserAPIController extends Controller
{
    //function to register customers
    public function createNewAccount(Request $request)
    {


        $rules = [
            "name" => "required|string",
            "email" => "required|email",
            "gender" => "required|string",
            "contact" => "required|min:10|max:10|unique:users,id",
            "password" => "required|same:confirm_password|min:8",
            "confirm_password" => "required|same:password",

        ];

        $request->validate($rules);

        //ensuring that customers register with unique emails and phonenumbers
        $existing_email = User::where("email", $request->email)->first();
        $existing_phone = User::where("contact", $request->contact)->first();


        if ($existing_email) {
            $response = [
                "success" => false,
                "message" => "User with this email  already exists",
            ];
            return response()->json($response, 403);

        } elseif ($existing_phone) {
            $response = [
                "success" => false,
                "message" => "User with this phone number  already exists",
            ];
            return response()->json($response, 403);

        } else {

            $user = new User();
            $user->name = ucwords($request->name);
            $user->email = $request->email;
            $user->contact = $request->contact;
            $user->gender = $request->gender;
            $user->user_type = 'customer';
            $password = $request->password;
            $user->password = Hash::make($password);

            $user->save();
            $user_token = Str::random(60);
            $success["token"] = $user->createToken($user_token)->plainTextToken;
            $success["id"] = $user->id;
            $success["name"] = $user->name;
            $success["email"] = $user->email;
            $success["gender"] = $user->gender;
            $success["contact"] = $user->contact;
            $success["user_type"] = $user->user_type;


            $response = [
                "success" => true,
                "data" => $success,
                "message" => "Account created successfully",
            ];

            return response()->json($response, 201);
        }
    }

    //function to login users
    public function login(Request $request)
    {


        $rules = [
            "email" => "required",
            "password" => "required",

        ];

        $request->validate($rules);
        $existing_user = User::Where("email", $request->email)->first();
        //dd($existing_user);

        if (!$existing_user) {
            $response = [
                "success" => false,
                "message" => "Email address doesn't exist",
            ];
            return response()->json($response, 404);
        } elseif ($existing_user && !Hash::check($request->password, $existing_user->password)) {
            $response = [
                "success" => false,
                "message" => "Invalid password",
            ];
            return response()->json($response, 400);
        } else {
            $user = Auth::user();
            $user_token = Str::random(60);
            $data["token"] = $existing_user->createToken($user_token)->plainTextToken;
            $data["id"] = $existing_user->id;
            $data["name"] = $existing_user->name;
            $data["email"] = $existing_user->email;
            $data["contact"] = $existing_user->contact;
            $data["type"] = $existing_user->user_type;
            $data["gender"] = $existing_user->gender;



            return response()->json(
                [
                    "success" => true,
                    "data" => $data,
                    "message" => "You successfully logged into your account"
                ]
            );
        }
    }


}
