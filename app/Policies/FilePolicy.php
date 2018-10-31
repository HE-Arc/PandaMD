<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\File;

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

        $security = $file->security;

        if ($security == 1 || $security == -1)
            return true;
        elseif ($security == 0 && $user != null) {
            return $user->id === $file->folder->user_id;
        } else {
            return false;
        }

    }

    public function edit(?User $user, File $file)
    {
        $security = $file->security;

        if ($security == -1) {
            return true;
        } elseif (($security != -1) && $user != null) {
            return $user->id === $file->folder->user_id;
        } else {
            return false;
        }
    }
}
