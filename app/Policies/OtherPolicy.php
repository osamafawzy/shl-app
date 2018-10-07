<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OtherPolicy
{
    use HandlesAuthorization;



    public function contact(User $user)
    {
        //
        return $this->getPermission($user,'التواصل مع الاداره');
    }

    public function condition(User $user)
    {
        //
        return $this->getPermission($user,'مواقع التواصل الاجتماعي');
    }
    public function social(User $user)
    {
        //
        return $this->getPermission($user,'احكام وشروط الخدمات');
    }


    protected function getPermission($admin,$p_title){
        foreach ($admin->roles as $role){
            foreach ($role->permissions as $permission){
                if ($permission->title == $p_title){
                    return true;
                }
            }
        }
        return false;
    }
}
