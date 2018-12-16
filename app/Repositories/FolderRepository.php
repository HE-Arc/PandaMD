<?php

namespace App\Repositories;

use App\Folder;
use App\Http\Requests\FolderRequest;
use App\Http\Requests\NameChangeRequest;
use App\User;


class FolderRepository
{

    public function store(User $user, FolderRequest $request)
    {
        $folder_id = $request->input('folderId');
        $name = $request->input('name');

        Folder::create([
            'name' => $name,
            'user_id' => $user->id,
            'folder_id' => $folder_id,
        ]);

    }

    public function updateName(Folder $folder, NameChangeRequest $request)
    {
        $newName = $request->input('newName');
        $folder->name = $newName;
        $folder->save();
    }

    public function updateFolder(Folder $folder,int $folderId, User $user)
    {
        $tabFolder = $user->folders->map(function ($folder) {
            return $folder->id;
        });

        $arrayRecursifFolder= $folder->getCascadedFolder();

        if ($tabFolder->contains($folderId) && !in_array($folderId, $arrayRecursifFolder)) {
            $folder->folder_id = $folderId;
            $folder->save();
            return true;
        } else {
            return false;
        }

    }

}