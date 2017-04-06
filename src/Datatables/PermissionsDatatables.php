<?php

namespace Aneeq\LaravelRbac\Datatables;

use Illuminate\Support\Facades\Config;
use Yajra\Datatables\Services\DataTable;

class PermissionsDatatables extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('actions', function($permission){
                return "<span><button class='btn btn-primary grid-row-update' data-id='$permission->id' data-parent_id='$permission->parent_id' data-name='$permission->name' data-display_name='$permission->display_name' data-description='$permission->description' data-type='$permission->type'"
                        . " data-url='$permission->url' data-parameters='$permission->parameters' data-url_query_string='$permission->url_query_string' data-css_class='$permission->css_class' data-main_menu='$permission->main_menu' data-sort_no='$permission->sort_no'><i class='fa fa-pencil'></i></button></span>
                        &nbsp; 
                        <span> <button class='btn btn-danger grid-row-delete' data-id='$permission->id'><i class='fa fa-trash'></i></button></span>";
            })
            ->addColumn('main_menu', function ($permission){
                return ($permission) ? 'Main Menu' : 'Not In Main Menu';
            })
            ->addColumn('parent', function ($permission){
//                dd((is_null($permission->parent_permission)) ? '' : $permission->parent_permission->display_name);
                return (is_null($permission->parent_permission)) ? '' : $permission->parent_permission->display_name;
            })
            ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $permissions_model = Config::get('laravelrbac.permissions_model');
        $query = $permissions_model::query();
        $query->with('parent_permission');

        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->ajax('')
                    ->addAction(['width' => '80px'])
                    ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'actions',
            'id',
            'parent',
            'name',
            'display_name',
            'description',
            'css_class',
            'main_menu',
            'sort_no'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'permissionsdatatables_' . time();
    }
}
