<?php

namespace Aneeq\LaravelRbac\Traits;

use Cache;
use Illuminate\Support\Facades\Config;

trait RbacUserTrait {

    public function roles() {
        return $this->belongsToMany(Config::get('laravelrbac.roles_model'), Config::get('laravelrbac.users_roles_table'), Config::get('laravelrbac.user_foreign_key'), Config::get('laravelrbac.role_foreign_key'));
    }

    public function cachedRoles() {
        $userPrimaryKey = $this->primaryKey;
        $cacheKey = 'laravelrbac_roles_for_user_' . $this->$userPrimaryKey;
        return Cache::rememberForever($cacheKey, function () {
                    return $this->roles()->get();
                });
    }
    
    public function flushCachedRoles (){
        $userPrimaryKey = $this->primaryKey;
        $cacheKey = 'laravelrbac_roles_for_user_' . $this->$userPrimaryKey;
        return Cache::forget($cacheKey);
    }

    public function hasRole($role_names, $require_all = false) {
        if (is_array($role_names)) {
            foreach ($role_names as $role_name) {
                $hasRole = $this->hasRole($role_name);

                if ($hasRole && !$require_all) {
                    return true;
                } elseif (!$hasRole && $require_all) {
                    return false;
                }
            }

            return $require_all;
        } else {
            foreach ($this->cachedRoles() as $role) {
                if ($role->name == $role_names) {
                    return true;
                }
            }
        }

        return false;
    }
    
    public function can($permissions, $require_all = false)
    {
        if (is_array($permissions)) {
            foreach ($permissions as $permission) {
                $hasPerm = $this->can($permission);

                if ($hasPerm && !$require_all) {
                    return true;
                } elseif (!$hasPerm && $require_all) {
                    return false;
                }
            }

            return $require_all;
        } else {
            foreach ($this->cachedRoles() as $role) {
                foreach ($role->cachedPermissions() as $perm) {
                    if (str_is( $permissions, $perm->name) ) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

}
