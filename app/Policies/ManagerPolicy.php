<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ManagerPolicy
{
    use HandlesAuthorization;


    public function view(User $user)
    {
        //
        return $this->getPermission($user,'عرض كل المسئولين');
    }

    /**
     * Determine whether the user can create services.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->getPermission($user,'اضافه مسئول');
    }

    /**
     * Determine whether the user can update the services.
     *
     * @param  \App\User  $user
     * @param  \App\Services  $services
     * @return mixed
     */
    public function update(User $user)
    {
        //
        return $this->getPermission($user,'تعديل مسئول');
    }


    /**
     * Determine whether the user can delete the services.
     *
     * @param  \App\User  $user
     * @param  \App\Services  $services
     * @return mixed
     */
    public function delete(User $user)
    {
        return $this->getPermission($user,'حذف مسئول');
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
