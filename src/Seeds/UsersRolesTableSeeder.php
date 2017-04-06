<?php

use Illuminate\Database\Seeder;

class UsersRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users_roles')->delete();
        
        \DB::table('users_roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 1,
                'role_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}
