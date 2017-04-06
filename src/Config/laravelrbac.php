<?php

return [
    'roles_model' => 'Aneeq\LaravelRbac\Models\RbacRole',
    'roles_table' => 'roles',
    'role_foreign_key' => 'role_id',
    'roles_view_backgroud_color' => '#fff',
    'assign_roles_view_background_color' => '#fff',
    
    'permissions_model' => 'Aneeq\LaravelRbac\Models\RbacPermission',
    'permissions_table' => 'permissions',
    'permission_foreign_key' => 'permission_id',
    'permissions_view_backgroud_color' => '#fff',
    
    'users_roles_table' => 'users_roles',
    'roles_permissions_table' => 'roles_permissions',
    
    'user_primary_key' => 'id',
    'user_foreign_key' => 'user_id',
    /*
     * Database Column Name used to display User 
     * E,g full_name, username
     */
    'user_display_name' => 'name',
    
    'authentication_middleware' => 'auth',
    
    'unauthorized_access_message' => 'Unauthorized Access',
    'unauthorized_access_redirect' => '/'
    
    
    
];

