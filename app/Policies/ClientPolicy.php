<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the services.
     *
     * @param  \App\User  $user
     * @param  \App\Services  $services
     * @return mixed
     */
    public function view(User $user)
    {
        //
        return $this->getPermission($user,'عرض عميل معين');
    }

    /**
     * Determine whether the user can create services.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->getPermission($user,'عرض كل العملاء');
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
        return $this->getPermission($user,'تشغيل و ايقاف عميل');
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
        //
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
