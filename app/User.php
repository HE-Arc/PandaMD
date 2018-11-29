<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Folder;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function folders()
    {
        return $this->hasMany(Folder::class);
    }

    public function getUserHomeFolder() {
        return $this->folders()->where(["name"=>"home"])->first();
    }

    public function getCascadedFolder()
    {
        $userFolder=$this->folders;
        $arrayFirstLevel=$userFolder->map(function ($folder){
            if($folder->folder_id==null)
            {
                return $folder;
            }

        });
        return $arrayFirstLevel;
    }
}
