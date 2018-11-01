<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = "files";

    public function folder() {
        return $this->belongsTo(Folder::class);
    }

    public function isEditable(?User $user){
        $security = $this->security;

        if ($security == File::$attr_editable) {
            return true;
        }
        return $user != null && $this->folder->user_id==$user->id;

    }

    public function isReadable(?User $user){
        $security = $this->security;

        if ($security == File::$attr_editable || $security == File::$attr_readable){
            return true;
        }
        return $user!=null && $user->id == $this->folder->user_id;
    }
    public static $attr_private ='private';
    public static $attr_readable ='readable';
    public static $attr_editable ='editable';
}
