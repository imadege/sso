<?php
/**
 * Created by PhpStorm.
 * User: imadege
 * Date: 9/24/16
 * Time: 1:28 PM
 */

/**
 * Implements roles and permissions.
 */
use Jenssegers\Mongodb\Model as Eloquent;
use App\User;
class Role extends Eloquent{
    protected $collection = 'roles';

    public function users(){
        return $this->belongsToMany('User');
    }

    /**
     * Get the users who have this permission assigned to them.
     */
    public function get_users(){
        $users = User::whereIn('role_ids',$this->id);

        return $users;
    }
}