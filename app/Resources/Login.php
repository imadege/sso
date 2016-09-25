<?php
/**
 * Created by PhpStorm.
 * User: imadege
 * Date: 9/24/16
 * Time: 8:59 PM
 */

namespace App\Resource;
use Illuminate\Support\Facades\Hash;

use App\Resource\User as User;
/***handles all Login details****/
class Login
{

    public $user;

    function  __construct()
    {
        $this->user = new User();
    }

    public function  auth($credentials){
        $user = $this->user->get_user_by_email($credentials['email']);
        if(!$user){
            return false;
        }
        if (Hash::check($credentials["password"], $user->password)) {
            return $user;

        }else{
            return false;
        }

    }

}