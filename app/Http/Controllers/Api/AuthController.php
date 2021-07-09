<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\User;

class AuthController extends BaseController
{

  /* USER LOGIN */
  public function login(Request $request) {
    $rules = [
      'email'    => 'required|string|email',
      'password' => 'required|string',
    ];
    $validator = Validator::make($request->all(), $rules);

    if($validator->fails()) {
      $errors = $validator->errors();
      return $this->sendError(implode(', ', $errors->all()));
    }

    $credentials = array(
      'email'     => $request->email,
      'password'  => $request->password,
    );

    if (!Auth::attempt($credentials)) {
      return $this->sendError('Oops! invalid credentials found.');
    }

    // Get the current user
    $user = $request->user();

    // create auth token for this user
    $token = $user->createToken('Personal Access Token For Messaging App')->accessToken;

    return $this->sendResponse( 'You have logged in successfully.' , ['user' => User::find($user->id), 'token' => $token]);
  }
  /* END OF USER LOGIN */

  // Get current user
  public function getUser(Request $request) {
    $user = User::find($request->user()->id);
    return $this->sendResponse( 'Data fetched successfully.' , $user );
  }

  // Logout user and revoke all tokens
  public function logout(Request $request) {
    // Delete All Access Tokens
    $tokens = $request->user()->tokens;
    foreach($tokens as $token) {
        $token->delete();
    }
    // $request->user()->token()->revoke(); // to revoke current token
    return $this->sendResponse( 'You have logged out successfully.' );
  }

  // Get all users
  public function getUsers(Request $request) {
    return $this->sendResponse( 'Data fetched successfully.' , User::all() );
  }

}
