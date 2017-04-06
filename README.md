# Laravel Role Based Access Control Package#
----------


## Prerequisite ##



- This library is built for laravel version 5.2
- Users Table exist in database with primary key "id"
- At least one user must with "id" => 1 exist in the table (User with Id "1" will be assumed "Admin").
 
 


## Installation



1 Install RBAC Package by adding the following lines into ***composer.json*** file

    <pre>"require": {
        "aneeq/laravelrbac": "dev-master"
    }</pre>

or

    composer require "aneeq/laravelrbac:dev-master"

 2 Add the below line in ***composer.json*** file.

	"Aneeq\\LaravelRbac\\": "vendor/aneeq/laravelrbac/src"

3 Add Provider into ***app.php*** config file.

	Aneeq\LaravelRbac\Providers\RbacServiceProvider::class

4 Add Middleware into routeMiddleware of ***App/Http/Kernel.php*** file.

	'role' => \Aneeq\LaravelRbac\Middleware\RbacRole::class,
    'permission' => \Aneeq\LaravelRbac\Middleware\RbacPermission::class

5 Publish Package Files. 