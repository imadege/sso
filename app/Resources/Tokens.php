<?php
/**
 * Created by PhpStorm.
 * User: imadege
 * Date: 9/24/16
 * Time: 9:44 PM
 */

namespace App\Resource;

/***will use these to decode and ecnode**/
use \Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
class Tokens
{

    public static function decode($token){
        $key  = env('JWT_SECRET');

        return JWT::decode($token, $key, array('HS256'));


    }
}