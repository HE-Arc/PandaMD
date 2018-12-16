<?php

namespace App\Repositories;

use App\File;
use App\Http\Requests\ChangeRightRequest;
use App\Http\Requests\NameChangeRequest;
use App\User;
use Carbon\Carbon;


class FilesRepository
{

    public function updateName(File $file, NameChangeRequest $request)
    {
        $newName = $request->input('newName');
        $file->title = $newName;
        $file->save();
    }

    public function updateRight(File $file, ChangeRightRequest $request)
    {

        $right = $request->input('newRight');

        $file->security = $right;
        $file->save();
    }

    public function newFile(User $user)
    {
        $folderId = $user->folders->where('folder_id', null)->first()->id;

        $newFile = File::create([
            'folder_id' => $folderId,
            'title'=> Carbon::now()->toDateTimeString(),
            'date'=> Carbon::now()->toDateString(),
        ]);
        return $newFile->id;

    }

    public function updateFolder(File $file,int $folderId,User $user)
    {
        $tabFolder = $user->folders->map(function($folder)
        {
            return $folder->id;
        });

        if($tabFolder->contains($folderId))
        {
            $file->folder_id=$folderId;
            $file->save();
            return true;
        }
        else{
            return false;
        }

    }

}