<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $fillable = [
        'name', 'user_id', 'folder_id',
    ];

    public static function createHomeFolder(int $id)
    {
        $home_folder = new Folder();
        $home_folder->name = "home";
        $home_folder->user_id = $id;
        return $home_folder;
    }

    protected $table = "folders";

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function folders()
    {
        return $this->hasMany(Folder::class)->orderBy('name');
    }

    public function foldersName()
    {
        return $this->folders->map(function ($folder) {
            return $folder->name;
        });
    }

    public function canCreatedFolder($name)
    {
        return !$this->foldersName()->contains($name);
    }

    public function canRenameFolder($name)
    {
        return !$this->foldersName()->contains($name) || $this->name==$name;
    }

    public function isUserFolder($user)
    {
        return $user->id === $this->user_id;
    }

    public function getCascadedFolder()
    {
        $arrayFolders = [];
        $this->recursifTreeFolder($this, $arrayFolders);
        return $arrayFolders;
    }

    private function recursifTreeFolder($currentFolder, &$arrayFolders)
    {
        $arrayTmp = $currentFolder->id;
        array_push($arrayFolders, $arrayTmp);

        foreach ($currentFolder->folders as $childFolder) {
            $this->recursifTreeFolder($childFolder, $arrayFolders);
        }
    }

    public function getPath()
    {
        $arrayPath = [$this];
        $fileTemp = $this;
        while($fileTemp->name!='home')
        {
            $fileTemp = Folder::find($fileTemp->folder_id);
            array_push($arrayPath, $fileTemp);
        }
        return $arrayPath;
    }
}
