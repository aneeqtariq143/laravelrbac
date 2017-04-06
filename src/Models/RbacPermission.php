<?php

namespace Aneeq\LaravelRbac\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Aneeq\LaravelRbac\Interfaces\RbacPermissionInterface;
use Aneeq\LaravelRbac\Traits\RbacPermissionTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class RbacPermission extends Model implements RbacPermissionInterface
{
    use RbacPermissionTrait, SoftDeletes;
    
    protected $table;

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->table = Config::get('laravelrbac.permissions_table');
    }
}
