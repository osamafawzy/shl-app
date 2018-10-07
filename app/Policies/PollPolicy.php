<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PollPolicy
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
        return $this->getPermission($user,'عرض صفحه الاستبيان');
    }

    /**
     * Determine whether the user can create services.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->getPermission($user,'اضافه استبيان');
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
        return $this->getPermission($user,'اضافه سؤال في استبيان معين');
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
        return $this->getPermission($user,'حذف سؤال معين');
    }

    public function deleteall(User $user)
    {
        //
        return $this->getPermission($user,'حذف الاستبيان بالكامل');
    }

    public function showquestion(User $user)
    {
        //
        return $this->getPermission($user,'عرض اسئله الاستبيان');
    }

    public function showresult(User $user)
    {
        //
        return $this->getPermission($user,'عرض نتائج الاستبيان');
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
