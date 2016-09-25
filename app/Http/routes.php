<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});
$app->get('/users','UserController@getusers') ;
$app->get('/users/{id}','UserController@getuser') ;


$app->get('/facebook/login','FbLoginController@fb_login') ;
$app->get('/facebook/callback','FbLoginController@fb_login_complete') ;


$app->post('/users/','UserController@adduser') ;
$app->post('/token/','TokenController@auth_token') ;
$app->post('/verify/','TokenController@verify') ;

$app->get('/token', function () use ($app) {
    echo "token"; exit;
});