<?php
/**
 * Created by PhpStorm.
 * User: imadege
 * Date: 9/24/16
 * Time: 10:34 AM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resource\User as  User;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
class UserController{

    /**
     * User Controller.
     *
     * @return void
     */

    public $user;
    function  __construct()
    {
        $this->user = new User();
    }

    public $Model = "";
    /*****List all users ****/
    public function getusers(){

        $user = $this->user->get_all();
        $response["message "] = $user;
        $respoonse["data"] = $user;
        return response($response, 200);

    }

    public function getuser(Request $request,$id){
        echo "get one user";
    }

    /******Recieves post request and signups a
     * Request
     ** parameters requer ar at least email and password
     ***/

    public function adduser(Request $request){


        $rules = [
            'email' => 'email|unique:users|required',
            'password' => 'required|min:8|max:25'
        ];
        //App::environment('production')
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $respoonse = [
                'message' => 'error',
                'message_description' => 'There were errors in your form.',
                'errors' => $validator->messages()
            ];

            return response($respoonse, 400);
        }else{
            $user = $this->user->add_user($request->all());
            print $user;
            /*$response["message "] = "Account Created";
            $respoonse["data"] = $user;
            return response($response, 200);*/
        }


    }
}