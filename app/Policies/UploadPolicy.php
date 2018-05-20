<?php

namespace App\Policies;

use App\Upload;
use App\User;
use App\UserGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class UploadPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the upload.
     *
     * @param  \App\User  $user
     * @param  \App\Upload  $upload
     * @return mixed
     */
    public function view(User $user, Upload $upload)
    {
        //
    }

    /**
     * Determine whether the user can create upload.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $user_array = UserGroup::where('group_id','1')
            ->pluck('user_id')->toArray();
        return in_array($user->id,$user_array);
    }

    /**
     * Determine whether the user can update the upload.
     *
     * @param  \App\User  $user
     * @param  \App\Upload  $upload
     * @return mixed
     */
    public function update(User $user, Upload $upload)
    {
        //
    }

    /**
     * Determine whether the user can delete the upload.
     *
     * @param  \App\User  $user
     * @param  \App\Upload  $upload
     * @return mixed
     */
    public function delete(User $user, Upload $upload)
    {
        //
    }
}
