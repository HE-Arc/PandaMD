<?php

namespace App\Repositories;

use App\File;
use App\Http\Requests\NameChangeRequest;
use App\User;
use Illuminate\Support\Facades\Auth;


class FilesRepository
{

    public function updateName(File $file, NameChangeRequest $request)
    {
        $newName=$request->input('newName');
        $file->title=$newName;
        $file->save();
    }


}