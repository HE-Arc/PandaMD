<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\File;

class Folder extends Model
{
    public static function createHomeFolder(int $id) {
        $home_folder = new Folder();
        $home_folder->name = "home";
        $home_folder->user_id = $id;
        return $home_folder;
    }

    protected $table = "folders";

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function files() {
        return $this->hasMany(File::class);
    }

    public function folders() {
        return $this->hasMany(Folder::class);
    }
}
