<?php
namespace  App\Resource;
/**
 * Created by Imadege.
 * Author: imadege
 * Date: 9/24/16
 * Time: 11:52 AM
 *
 * These Resource will Fetch update delete user
 */

use App\User as Model;
use Illuminate\Support\Facades\Hash;

use App\Role;
class User{



    public $custom_model = "";

    function __construct()
    {
        $user = new Model();
        $this->custom_model = new Model();//->getConnection()->table('users');
    }


    /****receive and array of user details
     * creates and account
     * @todo figure our how to integrate roles and permission
     * @todo integrate sending of mail
     ***/

    public function add_user($user_payload){
        if(!isset($user_payload['email']) || !isset($user_payload['password'])){
            return false;
        }
        $user_lastest = $this->latest();
        $user  = new Model();
        $user->email = $user_payload["email"];
        $user->password =  Hash::make($user_payload['password']);
        $user->uid = $user_lastest->uid +  1;
        if(isset($user_payload['first_name'])){
            $user->first_name = $user_payload["first_name"];

        }
        if(isset($user_payload['last_name'])){
            $user->last_name = $user_payload["last_name"];

        }
        if(isset($user_payload['last_name']) && isset($user_payload['first_name'])){
            $user->name = $user_payload['first_name']." ".$user_payload['last_name'];
        }


        $user->save();

        return $user;
    }



    /***let update users profle
        **@param array
     **/

    public function update($id,$user_payload){

        $user = Model::where('uid','=',(int)$id)->first();
        if(isset($user_payload['first_name'])){
            $user->first_name = $user_payload["first_name"];

        }
        if(isset($user_payload['last_name'])){
            $user->last_name = $user_payload["last_name"];

        }
        if(isset($user_payload['last_name']) && isset($user_payload['first_name'])){
            $user->name = $user_payload['first_name']." ".$user_payload['last_name'];
        }

        $user->save();

        return $user;


    }


    /***get all users***/
    public function get_all(){
        return $this->custom_model->get();
    }



    /***get latest user object***/

    public function latest(){
        $user = $this->custom_model->orderBy('uid', 'DESC')->take(1)->get();
        if(count($user)>0){
            $user = $user[0];
        }
        return $user;
    }


    /***filter by ID ***/
    public function get_user($Id){
        if(!is_int($Id)){
            $Id = (int)$Id;
        }
        $user = $this->custom_model->where('uid','=',$Id)->get();
        if(isset($user) && count($user)>0){
            return $user[0];
        }else{
            return $user =  [];
        }

    }


    /***delete user**/
    public function remove($id){
        if(!is_int($id)){
            $id = (int)$id;
        }
        if(Model::where('uid','=',$id)->delete()){
            return true;
        }else{
            return false;
        };

    }


    /***get user By Mail***/
    public function  get_user_by_email($email){
        return $this->custom_model->where('email','=',$email)->first();

    }





}