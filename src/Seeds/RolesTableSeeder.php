<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'admin',
                'display_name' => 'Admin',
                'description' => 'Administrator',
                'created_at' => '2017-04-04 09:03:10',
                'updated_at' => '2017-04-04 09:03:10',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}
