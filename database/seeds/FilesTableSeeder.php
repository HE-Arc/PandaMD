<?php

use App\File;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FilesTableSeeder extends Seeder
{
    public static function createSaveFile(array $args)
    {
        $file = new File();
        $file->folder_id = $args["folder_id"];
        $file->content = $args["content"];
        $file->is_title_page = $args["is_title_page"];
        $file->is_toc = $args["is_toc"];
        $file->is_toc_own_page = $args["is_toc_own_page"];
        $file->is_links_as_notes = $args["is_links_as_notes"];
        $file->title = $args["title"];
        $file->subtitle = $args["subtitle"];
        if(isset($args["school"])) {
            $file->school = $args["school"];
        }
        $file->date = Carbon::now()->toDateString();
        $file->save();
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
            foreach ($user->folders as $folder) {
                self::createSaveFile([
                    "folder_id" => $folder->id,
                    "content" => "# It's the $user->name folder\n##It's called $folder->name\n* elem 1\n*e elem 2",
                    "is_title_page" => true,
                    "is_toc" => true,
                    "is_toc_own_page" => true,
                    "is_links_as_notes" => true,
                    "title" => "$user->name_$folder->name",
                    "subtitle" => "greate subtitle"
                ]);
            }
        }
    }
}
