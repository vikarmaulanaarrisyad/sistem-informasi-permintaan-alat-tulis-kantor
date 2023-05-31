<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = User::factory(4)->create();

        $admin = User::first();
        $admin->name = 'Administrator';
        $admin->email = 'admin@gmail.com';
        $admin->password = Hash::make('123456');
        $admin->password_user = 123456;
        $admin->role_id = 1;
        $admin->save();

        $komputer = User::findOrfail(2);
        $komputer->name = 'D3 Teknik Komputer';
        $komputer->email = 'teknik.komputer@gmail.com';
        $komputer->password = Hash::make('komputer');
        $komputer->role_id = 2;
        $komputer->password_user = 'komputer';
        $komputer->save();

        $elektro = User::findOrfail(3);
        $elektro->name = 'D3 Teknik Elektro';
        $elektro->email = 'teknik.elektro@gmail.com';
        $elektro->password = Hash::make('elektro');
        $elektro->role_id = 2;
        $elektro->password_user = 'elektro';
        $elektro->save();

        $informatika = User::findOrfail(4);
        $informatika->name = 'D4 Teknik informatika';
        $informatika->email = 'teknik.informatika@gmail.com';
        $informatika->password = Hash::make('informatika');
        $informatika->role_id = 2;
        $informatika->password_user = 'informatika';
        $informatika->save();
    }
}
