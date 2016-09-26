<?php

/**
 * Login with Facebook
 */

namespace App\Http\Controllers;

use App\Resource\User as User;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk as Facebook;
use Illuminate\Support\Facades\Redirect;
class FbLoginController extends  Controller{


    public $fb;

    function __construct()
    {
        $this->fb = app(\SammyK\LaravelFacebookSdk\LaravelFacebookSdk::class);

        //$this->fb= new \SammyK\LaravelFacebookSdk\LaravelFacebookSdk();
    }

    /**
     * Redirect the user to Facebook to perform a login.
     */
    public function fb_login(){

       // echo env('FACEBOOK_REDIRECT_URL');
       /* $this->fb->getRedirectLoginHelper()
            ->getLoginUrl(app('url')->to('facebook/callback'), ['email']);*/
       echo app('url')->to('facebook/callback'); exit;
        //return redirect($this->fb->getLoginUrl(['email']));
    }

    /**
     * complete the login from Facebook.
     *
     */
    public function fb_login_complete(){

       /* try {
            $token = $this->fb->getAccessTokenFromRedirect();
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            dd($e->getMessage());
            exit;
        }*/

/*        $token = $this->fb->getTokenFromRedirect();

        if ( ! $token)
        {


            return response(["error"=>"Fabook login failed, token missing "],401 );
        }

        //Set the access token
        $this->fb->setAccessToken($token);

        $facebook_user = $this->fb->object('me')->fields('id','name','email','first_name','last_name')->get();

        $userdata = json_decode($facebook_user,true);
        return response($userdata,200);*/

 /*       $facebook_email = $userdata['email'];

        $facebook_user_id = $userdata['id'];

        $users = User::orderBy('uid', 'DESC')->take(1)->get();

        //Is the user logged in? Connect their accounts
        if (Auth::check()) {
            $user = Auth::user();

            $user->facebook_user_id = $facebook_user_id;
            $user->facebook_email = $facebook_email;
            $user->facebook_access_token = $token->access_token;
            $user->save();

            return Redirect::to('reporter/'. $user->uid . '/edit');
        }

        //Check if the user exists
        $user = User::where('email','=',$facebook_email)
            ->orWhere('facebook_email','=',$facebook_email)
            ->first();


        if (!$user) {
            $confirmation_token = Crypt::encrypt($facebook_email);
            //Create a new user
            $new_user = new User;
            $new_user->name = $userdata['name'];
            $new_user->facebook_name = $userdata['name'];
            $new_user->facebook_user_id = $facebook_user_id;
            $new_user->email = $facebook_email;
            $new_user->facebook_email = $facebook_email;
            $new_user->facebook_access_token = $token->access_token;
            $new_user->confirmation_token = $confirmation_token;

            foreach ($users as $account) {
                $uid = $account->uid;

                if (isset($uid)) {
                    $new_user->uid = $uid+1;
                }
                else{
                    $new_user->uid=1;
                }
            }

            $new_user->save();

            //Manually log in the user and redirect to profile page.
            Auth::login($new_user);

            //Send a welcome email.
            $email_data = array(
                'confirmation_token' => $confirmation_token,
                'confirm_url' => URL::to('/') . '/account/verify/' . $confirmation_token,
            );

            Mail::send('emails.users.signup', $email_data, function($message) use ($facebook_email)
            {
                $message->to($facebook_email)->subject('Welcome to Hivisasa.Com');
            });

            $obj = new Signup;
            $obj->followup_email($new_user->email);

            return Redirect::to('signup/complete');


        }
        else {
            //The user exists so we only add the facebook details to them for future use.
            if (!$user->facebook_user_id) {
                $user->facebook_user_id = $facebook_user_id;
            }

            if (!$user->facebook_email) {
                $user->facebook_email = $facebook_email;
            }

            if (!$user->facebook_name) {
                $user->facebook_name = $userdata['name'];
            }

            $user->facebook_access_token = $token->access_token;
            //Not too sure about this.
            $user->save();
            Auth::login($user,true);
            $auth['email'] = $user->email;
            $auth['username'] = $user->username;
            $auth['uid'] = $user->uid;
            $auth['id'] = $user->id;
            //@todo Some badge or points or notification to be sent out.
            $user_data = json_encode($auth);

            return Redirect::intended('/reporter/' . Auth::user()->uid)
                ->withCookie(Cookie::make('user_cookie', $user_data,60000));
        }*/
        echo "we are here";exit;
    }

    public function disconnect_fb(){
        $user = Auth::user();

        $user->unset('facebook_user_id');
        $user->unset('facebook_email');

        return Redirect::to('reporter/'.$user->uid);
    }
}