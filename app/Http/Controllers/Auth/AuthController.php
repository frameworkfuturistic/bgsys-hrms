<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    /**
     * | Created On-08-02-2023 
     * | Created By-Anshu Kumar
     * | User Authentications 
     */

    public function register(Request $req)
    {
        $validator = Validator::make($req->all(), [
            "name" => "required",
            "email" => "required|unique:users,email",
            "mobile" => "required|unique:users,mobile|numeric|digits:10",
            "password" => "required",
            "cPassword" => "required|same:password"
        ]);

        if ($validator->fails()) {
            return responseMsg(false, $validator->errors(), "");
        }

        try {
            $user = new User();
            $user->name = $req->name;
            $user->email = $req->email;
            $user->mobile = $req->mobile;
            $user->password = Hash::make($req->password);
            $user->save();
            return responseMsg(true, "User Successfully Registered", "");
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * | Edit Employees
     */
    public function edit(Request $req)
    {
        $validator = Validator::make($req->all(), [
            "id" => "required|integer",
            "name" => "required",
            "email" => [
                "required", "email",
                Rule::unique('users')
                    ->ignore($req->id)
            ],
            "mobile" => [
                "required", "numeric", "digits:10",
                Rule::unique('users')
                    ->ignore($req->id)
            ],
            "status" => "required|boolean"
        ]);

        if ($validator->fails()) {
            return responseMsg(false, $validator->errors(), "");
        }
        try {
            $user = User::find($req->id);
            $user->name = $req->name;
            $user->email = $req->email;
            $user->mobile = $req->mobile;
            $user->status = $req->status;
            if ($req->password) {
                $user->password = Hash::make($req->password);
            }
            $user->save();
            return responseMsg(true, "User Successfully Updated", "");
        } catch (Exception $e) {
            return responseMsg(false, $e->getMessage(), "");
        }
    }

    // V2
    public function login(Request $req)
    {
        $validator = Validator::make($req->all(), [
            "email" => "required|email",
            "password" => "required",
        ]);

        if ($validator->fails()) {
            return responseMsg(false, $validator->errors(), "");
        }

        try {
            if (Auth::attempt(['email' => $req->email, 'password' => $req->password])) {
                $user = Auth::user();
                if ($user->status == 0) {
                    return responseMsg(
                        true,
                        "You Are not Allowed to Logged in",
                        ""
                    );
                }
                $success['token'] = $user->createToken('MyApp')->plainTextToken;
                $success['name'] = $user->name;
                return response()->json(
                    [
                        'status' => true,
                        'message' => "You Have Logged In!!",
                        'data' =>  $success['token']
                    ]
                );
            }
            throw new Exception("Email Or Password Incorrect");
        } catch (Exception $e) {
            return responseMsg(false, $e->getMessage(), "");
        }
    }

    public function logout(Request $req)
    {
        try {
            $auth = auth()->user();
            if (!$auth)
                throw new Exception("You Should have authenticated first");
            $auth->tokens()->delete();
            return responseMsg(true, "You have Logged Out!!", "");
        } catch (Exception $e) {
            return responseMsg(false, $e->getMessage(), "");
        }
    }

    /**
     * | Change password
     */
    public function changePassword(Request $req)
    {
        $validator = Validator::make($req->all(), [
            "oldPassword" => "required",
            "newPassword" => "required",
        ]);

        if ($validator->fails()) {
            return responseMsg(false, $validator->errors(), "");
        }

        // Logics
        try {
            $userId = auth()->user()->id;
            $user = User::find($userId);
            if (Hash::check($req->oldPassword, $user->password)) {
                $user->password = Hash::make($req->newPassword);
                $user->save();
                return responseMsg(true, "Password Changed Successfully", "");
            }
            return responseMsg(
                false,
                "Old Password is Incorrect",
                ""
            );
        } catch (Exception $e) {
            return responseMsg(false, $e->getMessage(), "");
        }
    }
}
