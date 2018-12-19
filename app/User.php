<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


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

    public function getUserHomeFolder()
    {
        return $this->folders()->where(["name" => "home"])->first();
    }

    public function getCascadedFolder()
    {
        $curentFolder = $this->folders()->whereNull('folder_id')->first();
        $arrayFolders = [];
        $this->recursifTreeFolder($curentFolder, $arrayFolders);
        return $arrayFolders;
    }


    private function recursifTreeFolder($currentFolder, &$arrayFolders, $depth = 0)
    {
        $arrayTmp = [$currentFolder, $depth];
        array_push($arrayFolders, $arrayTmp);
        $depth++;
        foreach ($currentFolder->folders as $childFolder) {

                $this->recursifTreeFolder($childFolder, $arrayFolders, $depth);

        }

    }
}
