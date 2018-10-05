<?php

use App\Folder;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function createSaveUser(array $args) {
        $user = new User();
        $user->name = $args["name"];
        $user->email = $args["email"];
        $user->password = bcrypt($args["password"]);
        $user->save();
        (Folder::createHomeFolder($user->id))->save();
    }

    public function run()
    {
        self::createSaveUser([
            "name" => "Claude",
            "email" => "claude@gmail.com",
            "password" => "pass1234"
        ]);

        self::createSaveUser([
            "name" => "Michel",
            "email" => "michel@gmail.com",
            "password" => "pass1234"
        ]);


        self::createSaveUser([
            "name" => "Didier",
            "email" => "didier@gmail.com",
            "password" => "pass1234"
        ]);
    }
}
