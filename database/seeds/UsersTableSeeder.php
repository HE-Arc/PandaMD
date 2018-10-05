<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = new User();
        $user1->name = "Claude";
        $user1->email = "claude@gmail.com";
        $user1->password = bcrypt("pass1234");
        $user1->save();

        $user2 = new User();
        $user2->name = "Michel";
        $user2->email = "michel@gmail.com";
        $user2->password = bcrypt("pass1234");
        $user2->save();

        $user3 = new User();
        $user3->name = "Didier";
        $user3->email = "didier@gmail.com";
        $user3->password = bcrypt("pass1234");
        $user3->save();
    }
}
