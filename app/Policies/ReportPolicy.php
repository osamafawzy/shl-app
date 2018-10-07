<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{
    use HandlesAuthorization;


    public function services(User $user)
    {
        //
        return $this->getPermission($user,'عرض تقارير الخدمات');
    }

    public function providers(User $user)
    {
        //
        return $this->getPermission($user,'عرض تقارير مزود الخدمة');
    }

    public function followproviders(User $user)
    {
        //
        return $this->getPermission($user,'تتبع نظام الرحلات');
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
