<?php

namespace App\Repositories;

use App\Folder;
use App\Http\Requests\FolderRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Boolean;

class FolderRepository
{

    public function store(FolderRequest $request)
    {
        $folder_id = $request->input('folderId');
        $name=$request->input('name');

        $user=Auth::user();

        Folder::create([
            'name' => $name,
            'user_id' => $user->id,
            'folder_id' => $folder_id,
        ]);

    }

    public function updateName(Folder $folder,FolderRequest $request)
    {
        $newName=$request->input('newName');
        $folder->name=$newName;
        $folder->save();
    }


}