<?php

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/view-roles', 'Aneeq\LaravelRbac\Controllers\RbacController@viewRoles')->middleware('permission:view-roles');
    Route::post('/get-roles', 'Aneeq\LaravelRbac\Controllers\RbacController@getRoles')->middleware('permission:view-roles');
    Route::post('/add-role', 'Aneeq\LaravelRbac\Controllers\RbacController@addRole')->middleware('permission:add-role');
    Route::post('/update-role', 'Aneeq\LaravelRbac\Controllers\RbacController@updateRole')->middleware('permission:update-role');
    Route::post('/delete-role', 'Aneeq\LaravelRbac\Controllers\RbacController@deleteRole')->middleware('permission:delete-role');
    
    Route::get('/view-permissions', 'Aneeq\LaravelRbac\Controllers\RbacController@viewPermissions')->middleware('permission:view-permissions');
    Route::post('/get-permissions', 'Aneeq\LaravelRbac\Controllers\RbacController@getPermissions')->middleware('permission:view-permissions');
    Route::post('/get-permissions-ajax', 'Aneeq\LaravelRbac\Controllers\RbacController@getAllPermissionsAjax')->middleware('permission:view-permissions');
    Route::post('/add-permission', 'Aneeq\LaravelRbac\Controllers\RbacController@addPermission')->middleware('permission:add-permission');
    Route::post('/update-permission', 'Aneeq\LaravelRbac\Controllers\RbacController@updatePermission')->middleware('permission:update-permission');
    Route::post('/delete-permission', 'Aneeq\LaravelRbac\Controllers\RbacController@deletePermission')->middleware('permission:delete-permission');
    
    Route::get('/assign-role-permissions/{role_id?}', 'Aneeq\LaravelRbac\Controllers\RbacController@assignRolePermissions')
            ->name('assign-role-permissions')
            ->middleware('permission:assign-permission');
    
    Route::post('/assign-role-permissions-ajax', 'Aneeq\LaravelRbac\Controllers\RbacController@assignRolePermissionsAjax')->middleware('permission:assign-permission');
    Route::post('/get-role-permissions-ajax', 'Aneeq\LaravelRbac\Controllers\RbacController@getRolePermissionsAjax')->middleware('permission:assign-permission');
    
    Route::get('/assign-user-roles/{user_id}', 'Aneeq\LaravelRbac\Controllers\RbacController@assignUserRoles')
            ->name('assign-user-roles')
            ->middleware('permission:assign-roles');
    Route::post('/assign-user-roles-ajax', 'Aneeq\LaravelRbac\Controllers\RbacController@assignUserRolesAjax')->middleware('permission:assign-roles');
    
    Route::get('/unauthorized-access', 'Aneeq\LaravelRbac\Controllers\RbacController@unauthorizedAccess');
});
