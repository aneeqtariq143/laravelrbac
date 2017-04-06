<?php

namespace Aneeq\LaravelRbac\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Aneeq\LaravelRbac\Interfaces\RbacRoleInterface;
use Aneeq\LaravelRbac\Traits\RbacRoleTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class RbacRole extends Model implements RbacRoleInterface{

    use RbacRoleTrait, SoftDeletes;
    
    protected $table;

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->table = Config::get('laravelrbac.roles_table');
    }
    
}
