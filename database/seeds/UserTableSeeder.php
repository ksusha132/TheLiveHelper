<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = Role::where('name', 'User')->first();
        $role_trainer = Role::where('name', 'Trainer')->first();
        $role_admin = Role::where('name', 'Admin')->first();

        $user = new User();
        $user->name = 'Vasya';
        $user->email = 'vasya@mail.ru';
        $user->password = bcrypt('123456');
        $user->activated = 1;
        $user->save();
        $user->roles()->attach($role_user);// атач чтобы в 3 связующую таблицу прописалась связь первый юзер = 1

        $trainer = new User();
        $trainer->name = 'Alexander';
        $trainer->email = 'alexander@mail.ru';
        $trainer->password = bcrypt('123456');
        $trainer->activated = 1;
        $trainer->save();
        $trainer->roles()->attach($role_trainer);

        $admin = new User();
        $admin->name = 'Ksusha';
        $admin->email = 'orlovaksusha@mail.ru';
        $admin->password = bcrypt('123456');
        $admin->activated = 1;
        $admin->save();
        $admin->roles()->attach($role_admin);
    }
}
