<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
//use App\Models\Role;

class DefaultUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create a default admin user
        $admin = new User();
        $admin->name = 'Administrator';
        $admin->email = 'admin@admin.com';
        $admin->password = Hash::make('000000');
        $admin->save();

        $admin->assignRole('super-admin'); //, 'web'


        // create a default user
        $user = new User();
        $user->name = 'User';
        $user->email = 'user@user.com';
        $user->password = Hash::make('000000');
        $user->save();
    }
}
