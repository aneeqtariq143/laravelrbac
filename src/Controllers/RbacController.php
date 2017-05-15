<?php

namespace Aneeq\LaravelRbac\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Aneeq\LaravelRbac\Datatables\RoleDatatable;
use Aneeq\LaravelRbac\Datatables\PermissionsDatatables;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Aneeq\LaravelRbac\Events\PreRolesAssignEvent;
use Aneeq\LaravelRbac\Events\PostRolesAssignEvent;
use Aneeq\LaravelRbac\Events\PrePermissionAssignEvent;
use Aneeq\LaravelRbac\Events\PostPermissionAssignEvent;

class RbacController extends Controller {

    public function viewRoles(Request $request) {
        $data = [
            'roles_view_backgroud_color' => Config::get('laravelrbac.roles_view_backgroud_color')
        ];
        return view('laravelrbac::roles', $data);
    }

    public function getRoles(Request $request, RoleDatatable $roles_datatables) {
        return $roles_datatables->ajax();
    }

    public function getAllRoles() {
        $role_model = Config::get('laravelrbac.roles_model');
        return $role_model::get();
    }

    public function addRole(Request $request) {
        $this->validate($request, [
            'name' => 'required|string|max:50|alpha_dash|unique:' . Config::get('laravelrbac.roles_table') . ',name,NULL,id,deleted_at,NULL',
            'display_name' => 'required|string|max:100',
            'description' => 'string|max:255'
        ]);

        $description = $request->input('description');
        $data = [
            'name' => $request->input('name'),
            'display_name' => $request->input('display_name'),
            'description' => (empty($description)) ? NULL : $description
        ];

        $role_model = Config::get('laravelrbac.roles_model');
        $role_model_object = new $role_model();
        if (is_array($data) && !empty($data)) {
            foreach ($data as $column => $value) {
                $role_model_object->$column = $value;
            }
        }

        $response = [];
        if ($role_model_object->save()) {
            $response['success'] = 'Role is Successfully Added';
        } else {
            $response['error'] = "Somthing's went wrong. Contact Support Center.";
        }
        return response()->json($response);
    }

    public function updateRole(Request $request) {
        $id = $request->input('id');
        $this->validate($request, [
            'id' => 'bail|required|integer',
            'name' => 'required|string|max:50|alpha_dash|unique:' . Config::get('laravelrbac.roles_table') . ',name' . ",$id,id" . ',deleted_at,NULL',
            'display_name' => 'required|string|max:100',
            'description' => 'required|string|max:255'
        ]);

        $description = $request->input('description');
        $data = [
            'name' => $request->input('name'),
            'display_name' => $request->input('display_name'),
            'description' => (empty($description)) ? NULL : $description
        ];

        $role_model = Config::get('laravelrbac.roles_model');

        $response = [];
        try {
            $role_model_object = $role_model::findOrFail($id);
            if (is_array($data) && !empty($data)) {
                foreach ($data as $column => $value) {
                    $role_model_object->$column = $value;
                }
            }
            if ($role_model_object->save()) {
                $response['success'] = 'Role is Successfully Updated';
            } else {
                $response['error'] = "Somthing's went wrong. Contact Support Center.";
            }
        } catch (ModelNotFoundException $ex) {
            $response['not_found'] = 'Record Not Found';
        }
        return response()->json($response);
    }

    public function deleteRole(Request $request) {
        $this->validate($request, [
            'id' => 'required|integer'
        ]);

        $id = $request->input('id');

        $role_model = Config::get('laravelrbac.roles_model');

        $response = [];
        try {
            $role_model_object = $role_model::findOrFail($id);
            if ($role_model_object->delete()) {
                $response['success'] = 'Role is Successfully Deleted';
            } else {
                $response['error'] = "Somthing's went wrong. Contact Support Center.";
            }
        } catch (ModelNotFoundException $ex) {
            $response['not_found'] = 'Record Not Found';
        }
        return response()->json($response);
    }

    public function viewPermissions(Request $request) {
        $data = [
            'permissions_view_backgroud_color' => Config::get('laravelrbac.permissions_view_backgroud_color'),
            'permissions_dropdown' => $this->generateDropDown($this->getAllPermissions())
        ];

        return view('laravelrbac::permissions', $data);
    }

    public function getPermissions(PermissionsDatatables $permissions_datatables) {
        return $permissions_datatables->ajax();
    }

    public function addPermission(Request $request) {
        $this->validate($request, [
            'parent_id' => 'integer',
            'name' => 'required|string|max:50|alpha_dash|unique:' . Config::get('laravelrbac.roles_table') . ',name,NULL,id,deleted_at,NULL',
            'display_name' => 'required|string|max:100',
            'description' => 'string|max:255',
            'type' => 'required|in:expand,open,button',
            'url' => 'string|max:255',
            'parameters' => 'string|max:255',
            'url_query_string' => 'string|max:255',
            'css_class' => 'string|max:50',
            'main_menu' => 'required|integer',
            'sort_no' => 'integer'
        ]);

        $parent_id = $request->input('parent_id');
        $description = $request->input('description');
        $url = $request->input('url');
        $parameters = $request->input('parameters');
        $url_query_string = $request->input('url_query_string');
        $css_class = $request->input('css_class');
        $sort_no = $request->input('sort_no');

        $data = [
            'parent_id' => (empty($parent_id)) ? NULL : $parent_id,
            'name' => $request->input('name'),
            'display_name' => $request->input('display_name'),
            'description' => (empty($description)) ? NULL : $description,
            'type' => $request->input('type'),
            'url' => (empty($url)) ? NULL : $url,
            'parameters' => (empty($parameters)) ? NULL : $parameters,
            'url_query_string' => (empty($url_query_string)) ? NULL : $url_query_string,
            'css_class' => (empty($css_class)) ? NULL : $css_class,
            'main_menu' => $request->input('main_menu'),
            'sort_no' => (empty($sort_no)) ? NULL : $sort_no
        ];

        $permission_model = Config::get('laravelrbac.permissions_model');
        $permission_model_object = new $permission_model();
        if (is_array($data) && !empty($data)) {
            foreach ($data as $column => $value) {
                $permission_model_object->$column = $value;
            }
        }

        $response = [];
        if ($permission_model_object->save()) {
            $response['success'] = 'Permission is Successfully Added';
        } else {
            $response['error'] = "Somthing's went wrong. Contact Support Center.";
        }
        return response()->json($response);
    }

    public function updatePermission(Request $request) {
        $id = $request->input('id');
        $this->validate($request, [
            'parent_id' => 'integer',
            'name' => 'required|string|max:50|alpha_dash|unique:' . Config::get('laravelrbac.roles_table') . ',name,' . $id . ',id,deleted_at,NULL',
            'display_name' => 'required|string|max:100',
            'description' => 'string|max:255',
            'type' => 'required|in:expand,open,button',
            'url' => 'string|max:255',
            'parameters' => 'string|max:255',
            'url_query_string' => 'string|max:255',
            'css_class' => 'string|max:50',
            'main_menu' => 'required|integer',
            'sort_no' => 'integer'
        ]);

        $parent_id = $request->input('parent_id');
        $description = $request->input('description');
        $url = $request->input('url');
        $parameters = $request->input('parameters');
        $url_query_string = $request->input('url_query_string');
        $css_class = $request->input('css_class');
        $sort_no = $request->input('sort_no');
        $data = [
            'parent_id' => (empty($parent_id)) ? NULL : $parent_id,
            'name' => $request->input('name'),
            'display_name' => $request->input('display_name'),
            'description' => (empty($description)) ? NULL : $description,
            'type' => $request->input('type'),
            'url' => (empty($url)) ? NULL : $url,
            'parameters' => (empty($parameters)) ? NULL : $parameters,
            'url_query_string' => (empty($url_query_string)) ? NULL : $url_query_string,
            'css_class' => (empty($css_class)) ? NULL : $css_class,
            'main_menu' => $request->input('main_menu'),
            'sort_no' => (empty($sort_no)) ? NULL : $sort_no
        ];

        $permissions_model = Config::get('laravelrbac.permissions_model');
        $response = [];

        if ($id === $data['parent_id']) {
            $response['parent_id'] = "Parent Cann't be reference to its own";
            return response()->json($response);
        }

        try {
            $permissions_model_object = $permissions_model::findOrFail($id);
            if (is_array($data) && !empty($data)) {
                foreach ($data as $column => $value) {
                    $permissions_model_object->$column = $value;
                }
            }
            if ($permissions_model_object->save()) {
                $response['success'] = 'Permission is Successfully Updated';
            } else {
                $response['error'] = "Somthing's went wrong. Contact Support Center.";
            }
        } catch (ModelNotFoundException $ex) {
            $response['not_found'] = 'Record Not Found';
        }
        return response()->json($response);
    }

    public function deletePermission(Request $request) {
        $this->validate($request, [
            'id' => 'required|integer'
        ]);

        $id = $request->input('id');

        $permissions_model = Config::get('laravelrbac.permissions_model');

        $response = [];
        try {
            $permissions_model_object = $permissions_model::findOrFail($id);
            if ($permissions_model_object->delete()) {
                $response['success'] = 'Permission is Successfully Deleted';
            } else {
                $response['error'] = "Somthing's went wrong. Contact Support Center.";
            }
        } catch (ModelNotFoundException $ex) {
            $response['not_found'] = 'Record Not Found';
        }
        return response()->json($response);
    }

    public function getAllPermissionsAjax(Request $request) {
        return $this->generateDropDown($this->getAllPermissions());
    }

    protected function getAllPermissions() {
        $permission_model = Config::get('laravelrbac.permissions_model');
        $parent_permissions = $permission_model::whereNull('parent_id')
                ->orderBy('sort_no')
                ->get();

        if (!$parent_permissions->isEmpty()) {
            $parent_permissions->transform(function ($item, $key) {
                $item->childrens = $this->getChildPermissions($item);
                return $item;
            });
        }

        return $parent_permissions;
    }

    protected function getChildPermissions($permission) {
        $permission_model = Config::get('laravelrbac.permissions_model');
        if ($permission instanceof $permission_model) {
            $temp_permissions = $permission->child_permissions()->orderBy('sort_no')->get();
            if (!$temp_permissions->isEmpty()) {
                $temp_permissions->transform(function ($item, $key) {
                    $item->childrens = $this->getChildPermissions($item);
                    return $item;
                });
            }

            return $temp_permissions;
        } else {
            throw new \InvalidArgumentException('Pass Permission Model');
        }
    }

    protected function generateDropDown(Collection $permissions, $indent = '') {
        $output = '';
        $indent = $indent;
        if (!$permissions->isEmpty()) {
            foreach ($permissions as $permission) {
                $color = ($permission->type == 'expand') ? 'style="color: #000;"' : 'style="color: #000;"';
                $output .= '<option ' . $color . ' value="' . $permission->id . '">' . $indent . $permission->display_name . '</option>';
                if (isset($permission->childrens) && !$permission->childrens->isEmpty()) {
                    $output .= $this->generateDropDown($permission->childrens, $indent . "&nbsp;&nbsp;&nbsp;&nbsp;");
                }
            }
            return $output;
        } else {
            return $output;
        }
    }

    public function assignRolePermissions(Request $request, $role_id = NULL) {
        $data = [
            'role_id' => $role_id,
            'roles' => $this->getAllRoles(),
            'permissions' => $this->getAllPermissions()
        ];

        return view('laravelrbac::assign_role_permissions', $data);
    }

    public function assignRolePermissionsAjax(Request $request) {
        $this->validate($request, [
            'role_id' => 'required|integer',
            'permission_ids.*' => 'required|integer'
        ]);

        $data = [
            'role_id' => $request->input('role_id'),
            'permission_ids' => $request->input('permission_ids')
        ];

        $role_model = Config::get('laravelrbac.roles_model');

        $response = [];
        try {
            $role_model_object = $role_model::findOrFail($data['role_id']);
            event(new PrePermissionAssignEvent($role_model_object->permissions));
            if ($role_model_object->permissions()->sync($data['permission_ids'])) {
                $role_model_object->flushCachedPermissions();
                $role_model_object = $role_model_object->fresh(['permissions']);
                event(new PostPermissionAssignEvent($role_model_object->permissions));
                $response['success'] = 'Permission are Successfully Assigned';
            } else {
                $response['error'] = "Somthing's went wrong. Contact Support Center.";
            }
        } catch (ModelNotFoundException $ex) {
            $response['not_found'] = 'Record Not Found';
        }
        return response()->json($response);
    }

    public function getRolePermissionsAjax(Request $request) {
        $this->validate($request, [
            'role_id' => 'required|integer'
        ]);

        $role_id = $request->input('role_id');

        $role_model = Config::get('laravelrbac.roles_model');

        $response = [];
        try {
            $role_model_object = $role_model::findOrFail($role_id);
            $response['permissions'] = $role_model_object->permissions;
        } catch (ModelNotFoundException $ex) {
            $response['not_found'] = 'Record Not Found';
        }
        return response()->json($response);
    }

    public function assignUserRoles(Request $request, $user_id = NULL) {
        $user_primary_key = Config::get('laravelrbac.user_primary_key');
        $user_display_name = Config::get('laravelrbac.user_display_name');
        try {
            $user = $this->getUsers((int) $user_id, [$user_primary_key, $user_display_name]);
        } catch (\Exception $ex) {
            abort(404, 'User Not Found');
        }

        $data = [
            'user_id' => $user_id,
            'user' => $user,
            'user_roles' => $user->roles->pluck('id')->all(),
            'user_display_name' => $user_display_name,
            'assign_roles_view_background_color' => Config::get('laravelrbac.assign_roles_view_background_color'),
            'roles' => $this->getAllRoles()
        ];

        return view('laravelrbac::assign_user_roles', $data);
    }

    public function assignUserRolesAjax(Request $request) {
        $this->validate($request, [
            'user_id' => 'required|integer',
            'role_ids.*' => 'required|integer'
        ]);

        $data = [
            'user_id' => $request->input('user_id'),
            'role_ids' => $request->input('role_ids')
        ];


        $user_model = Config::get('auth.providers.users.model');

        $response = [];
        try {
            $user_model_object = $user_model::findOrFail($data['user_id']);
            event(new PreRolesAssignEvent($user_model_object->roles));
            if ($user_model_object->roles()->sync($data['role_ids'])) {
                $user_model_object->flushCachedRoles();
                $user_model_object = $user_model_object->fresh(['roles']);
                event(new PostRolesAssignEvent($user_model_object->roles));
                $response['success'] = 'Roles are Successfully Assigned';
            } else {
                $response['error'] = "Somthing's went wrong. Contact Support Center.";
            }
        } catch (ModelNotFoundException $ex) {
            $response['not_found'] = 'Record Not Found';
        }
        return response()->json($response);
    }

    public function getUsers($user_id = NULL, $columns = []) {
        $user_model = Config::get('auth.providers.users.model');
        $user_primary_key = Config::get('laravelrbac.user_primary_key');

        $query = $user_model::when((is_array($columns) && !empty($columns)), function ($query) use ($columns) {
                    return $query->select($columns);
                });

        if (is_null($user_id)) {
            return $query->get();
        } else {
            $query->where($user_primary_key, $user_id);
            return $query->firstOrFail();
        }
    }

    public function unauthorizedAccess(Request $request) {
        return view('laravelrbac::errors.unauthorized_403');
    }
    
    

}
