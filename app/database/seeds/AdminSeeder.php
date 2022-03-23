<?php

use Illuminate\Database\Seeder;
use App\User;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->userID = $user->getUserID();
        $user->username = 'superuser';
        $user->name = 'Kang Cin Ho';
        $user->password = bcrypt('superuser');
        $user->isAdmin = true;
        $user->isMaster = true;
        $user->isFA = true;
        $user->isCreate = true;
        $user->isUpdate = true;
        $user->isDelete = true;
        $user->save();
    }
}
