# Laravel Role Based Access Control Package#
----------


## Prerequisite ##



- This library is built for laravel version 5.2
- Users Table exist in database with primary key "id"
- At least one user must with "id" => 1 exist in the table (User with Id "1" will be assumed "Admin").
 
 


## Installation



1 Install RBAC Package by adding the following lines into ***composer.json*** file

    "require": {
        "aneeq/laravelrbac": "dev-master"
    }

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

	php artisan vendor:publish --provider="Aneeq\LaravelRbac\Providers\RbacServiceProvider"


 The above command will copy ***Config, Migrations, Seeds and views*** file.

 Note: If you want to Publish Specific files then, use the above command with `--tag="config"`

6 Migrate and Seed published tables.

	php artisan migrate
	php artisan db:seed --class=RolesTableSeeder
	php artisan db:seed --class=PermissionsTableSeeder
	php artisan db:seed --class=RolesPermissionsTableSeeder
	php artisan db:seed --class=UsersRolesTableSeeder

7 Implement ***RbacUserInterface*** and ***RbacUserTrait*** on Laravel ***User*** Model

	use Aneeq\LaravelRbac\Interfaces\RbacUserInterface;
	use Aneeq\LaravelRbac\Traits\RbacUserTrait;

	class User extends Authenticatable implements RbacUserInterface
	{
    	use RbacUserTrait;


Installation Completed