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

 2 Add the below line in autoload ps4 selection of ***composer.json*** file.

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

##Usage##

1 Controller Authorization

	if(!$request->user()->can('dashboad')){
            return redirect('unauthorized-access');
    }

2 Middleware Authorization

	Route::get('/url', 'Controller@function')->middleware('permission:permission-name')

3 view File Authorization

	<?php if (Auth::user()->can('dashboard')) {}?>

###Events###

This package raises 4 event during "Assigning Permissions to the role" and "Assign Roles to the user". You may attach listeners to these events in your ***App\Providers\EventServiceProvider***

	/**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Aneeq\LaravelRbac\Events\PreRolesAssignEvent' => [ // This event raise before Roles assigned to the User
            // Here is the list of User Defined Listner Class
            'App\Listeners\PreRolesAssignEventListener',
        ],
        'Aneeq\LaravelRbac\Events\PostRolesAssignEvent' => [ // This event raise after Roles assigned to the User
            // Here is the list of User Defined Listner Class        
            'App\Listeners\PostRolesAssignEventListener',
        ],
        'Aneeq\LaravelRbac\Events\PrePermissionAssignEvent' => [ // This event raise before Permissions assigned to the Role
            // Here is the list of User Defined Listner Class
            'App\Listeners\PrePermissionAssignEventListner',
        ],
        'Aneeq\LaravelRbac\Events\PostPermissionAssignEvent' => [ // This event raise After Permissions assigned to the Role
            // Here is the list of User Defined Listner Class//
            'App\Listeners\PostPermissionAssignEventListner',
        ],
    ];


Example of Pre & Post RolesAssignEvent


	<?php

	namespace App\Listeners;
	
	use Aneeq\LaravelRbac\Events\PreRolesAssignEvent;
	use Illuminate\Queue\InteractsWithQueue;
	use Illuminate\Contracts\Queue\ShouldQueue;
	
	class PreRolesAssignEventListener
	{
	    /**
	     * Create the event listener.
	     *
	     * @return void
	     */
	    public function __construct()
	    {
	        //
	    }
	
	    /**
	     * Handle the event.
	     *
	     * @param  PreRolesAssignEvent  $event
	     * @return void
	     */
	    public function handle(PreRolesAssignEvent $event)
	    {
			//dd($event->roles);
		}
	     
	}


Example of Pre & Post PermissionAssignEvent

	<?php

	namespace App\Listeners;
	
	use Aneeq\LaravelRbac\Events\PostPermissionAssignEvent;
	use Illuminate\Queue\InteractsWithQueue;
	use Illuminate\Contracts\Queue\ShouldQueue;
	
	class PostPermissionAssignEventListner
	{
	    /**
	     * Create the event listener.
	     *
	     * @return void
	     */
	    public function __construct()
	    {
	        //
	    }
	
	    /**
	     * Handle the event.
	     *
	     * @param  PostPermissionAssignEvent  $event
	     * @return void
	     */
	    public function handle(PostPermissionAssignEvent $event)
	    {
	        //dd($event->permissions);
	    }
	}
