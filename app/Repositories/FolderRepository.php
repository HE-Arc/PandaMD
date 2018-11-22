<?php

namespace App\Repositories;

use App\Folder;
use App\Http\Requests\FolderRequest;
use App\Http\Requests\NameChangeRequest;
use App\User;
use Illuminate\Support\Facades\Auth;


class FolderRepository
{

    public function store(User $user,FolderRequest $request)
    {
        $folder_id = $request->input('folderId');
        $name=$request->input('name');

        Folder::create([
            'name' => $name,
            'user_id' => $user->id,
            'folder_id' => $folder_id,
        ]);

    }

    public function updateName(Folder $folder, NameChangeRequest $request)
    {
        $newName=$request->input('newName');
        $folder->name=$newName;
        $folder->save();
    }


}