<?php

namespace Aneeq\LaravelRbac\Traits;

use Illuminate\Support\Facades\Config;

trait RbacPermissionTrait {

    public function roles() {
        return $this->belongsToMany(Config::get('laravelrbac.permissions_model'), Config::get('laravelrbac.roles_permissions_table'), Config::get('laravelrbac.permission_foreign_key'), Config::get('laravelrbac.role_foreign_key'));
    }
    
    public function parent_permission (){
        return $this->belongsTo(Config::get('laravelrbac.permissions_model'), 'parent_id', 'id');
    }
    
    public function child_permissions (){
        return $this->hasMany(Config::get('laravelrbac.permissions_model'), 'parent_id', 'id');
    }

}
