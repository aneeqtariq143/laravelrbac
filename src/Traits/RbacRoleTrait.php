<?php

namespace Aneeq\LaravelRbac\Traits;

use Cache;
use Illuminate\Support\Facades\Config;

trait RbacRoleTrait {

    public function users() {
        return $this->belongsToMany(Config::get('auth.providers.users.model'), Config::get('laravelrbac.users_roles_table'), Config::get('laravelrbac.role_foreign_key'), Config::get('laravelrbac.user_foreign_key'));
    }

    public function permissions() {
        return $this->belongsToMany(Config::get('laravelrbac.permissions_model'), Config::get('laravelrbac.roles_permissions_table'), Config::get('laravelrbac.role_foreign_key'), Config::get('laravelrbac.permission_foreign_key'));
    }

    public function cachedPermissions() {
        $rolePrimaryKey = $this->primaryKey;
        $cacheKey = 'laravelrbac_permissions_for_role_' . $this->$rolePrimaryKey;
        return Cache::rememberForever($cacheKey, function () {
                    return $this->permissions()->get();
                });
    }
    
    public function flushCachedPermissions (){
        $rolePrimaryKey = $this->primaryKey;
        $cacheKey = 'laravelrbac_permissions_for_role_' . $this->$rolePrimaryKey;
        return Cache::forget($cacheKey);
    }
    
    public function hasPermission($permissions, $requireAll = false)
    {
        if (is_array($permissions)) {
            foreach ($permissions as $permission) {
                $hasPermission = $this->hasPermission($permission);

                if ($hasPermission && !$requireAll) {
                    return true;
                } elseif (!$hasPermission && $requireAll) {
                    return false;
                }
            }

            return $requireAll;
        } else {
            foreach ($this->cachedPermissions() as $permission) {
                if ($permission->name == $permissions) {
                    return true;
                }
            }
        }

        return false;
    }

}
