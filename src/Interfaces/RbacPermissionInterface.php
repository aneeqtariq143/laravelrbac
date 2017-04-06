<?php

namespace Aneeq\LaravelRbac\Interfaces;

interface RbacPermissionInterface {
    
    public function roles();
    
    public function parent_permission ();
    
    public function child_permissions ();
}
