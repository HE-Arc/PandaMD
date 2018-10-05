<?php

use Illuminate\Database\Seeder;
use App\Folder;
use App\User;

class FoldersTableSeeder extends Seeder
{
    public static function createSaveFolder(array $args)
    {
        $folder = new Folder();
        $folder->name = $args["name"];
        $folder->folder_id = $args["folder_id"];
        $folder->user_id = $args["user_id"];
        $folder->save();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        foreach ($users as $user) {
            self::createSaveFolder([
                "name" => "Maths",
                "folder_id" => $user->getUserHomeFolder()->id,
                "user_id" => $user->id
            ]);
            self::createSaveFolder([
                "name" => "Informatique",
                "folder_id" => $user->getUserHomeFolder()->id,
                "user_id" => $user->id
            ]);
        }
    }
}
