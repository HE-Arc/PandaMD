<?php

namespace App\Policies;

use App\File;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function read(?User $user, File $file)
    {

       return $file->isReadable($user);

    }

    public function edit(?User $user, File $file)
    {

        return $file->isEditable($user);
    }

    public function changeFile(User $user, File $file){

        return $file->canChangeFile($user);
    }

}
