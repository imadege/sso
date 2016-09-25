<?php
/**
 * Created by PhpStorm.
 * User: imadege
 * Date: 9/24/16
 * Time: 1:55 PM
 */

namespace App\Http\Controllers;

/****Thise controller handles token generation and refresf
 * Maintin session
 * /
 * ***/

use Herrera\Json\Exception\Exception;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Resource\Login as Login;
use App\Resource\Tokens as Token;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

class TokenController
{

/***generate token for our user***/
public function auth_token(Request $request)
{
    $rules = [
        'email' => 'required',
        'password' => 'required|min:8|max:25'
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        $respoonse = [
            'message' => 'error',
            'message_description' => 'There were errors in your form.',
            'errors' => $validator->messages()
        ];

        return response($respoonse, 400);
    } else {

        $login = new Login();

        //let login user
        $user = $login->auth($this->getCredentials($request));

        try {

            if ($user) {
                //let generate tokens
                $token = JWTAuth::fromUser($user);
                return response()->json(compact('token'));
            } else {
                $respoonse["Message"] = "Failed Auth ";

                return response()->json(['error' => 'Could not Create Token ,  Wrong usermane/password'], 401);
            }

        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not Create Token '], 500);
        }
    }
}




    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return $request->only('email', 'password');
    }

    /**
     * Verify Token
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function verify(Request $request){
        $rules = [
            'token' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $respoonse = [
                'message' => 'error',
                'message_description' => 'There were errors in your form.',
                'errors' => $validator->messages()
            ];
            return response()->json($respoonse, 400);
        }else{
            $data = $request->only('token');
            try{
                $decoded = Token::decode($data["token"]);
                return response()->json(["data"=>$decoded,"message"=>"signature valid"],200);
            }catch (SignatureInvalidException $e){
                return response()->json(["error"=>"Signature Invalid"],400);
            }catch (ExpiredException $e){
                return response()->json(["error"=>"Token Expire"],400);
            }catch(\Exception $e){
                return response()->json(["error"=>"unable to decoed key"],400);
            }


        }
    }








}