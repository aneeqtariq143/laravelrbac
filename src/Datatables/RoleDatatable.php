<?php

namespace Aneeq\LaravelRbac\Datatables;

use Illuminate\Support\Facades\Config;
use Yajra\Datatables\Services\DataTable;

class RoleDatatable extends DataTable
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
            ->addColumn('actions', function($role){
                return "<span><a href='". route("assign-role-permissions", ['role_id' => $role->id]) ."'><button class='btn btn-primary grid-row-permissions'><i class='fa fa-lock'></i></button></a></span>"
                        . "&nbsp;<span><button class='btn btn-primary grid-row-update' data-id='$role->id' data-name='$role->name' data-display_name='$role->display_name' data-description='$role->description'><i class='fa fa-pencil'></i></button></span>
                        &nbsp; 
                        <span> <button class='btn btn-danger grid-row-delete' data-id='$role->id'><i class='fa fa-trash'></i></button></span>";
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
        $role_model = Config::get('laravelrbac.roles_model');
        $query = $role_model::query();

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
            'name',
            'display_name',
            'description'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'roledatatables_' . time();
    }
}
