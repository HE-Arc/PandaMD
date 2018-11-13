<?php

namespace App\Repositories;

use App\Folder;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Boolean;

class FolderRepository
{

    public function store($request)
    {
        $user=Auth::user();
        Folder::create([
            'name' => $request->input('name'),
            'user_id' => $user->id,
            'folder_id' => $request->input('folderId'),
        ]);
    }

    public function updateName($folder,$request)
    {
        $newName=$request->input('newName');
        $folder->name=$newName;
        $folder->save();
    }


}