<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ProjectServices
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAllProjectByUser($user)
   {
       // project as owner
       $projectOwnedByUser = $user->projectOwnerProjects()->get();
       $projectOwnedByUser = !is_null($projectOwnedByUser) ? $projectOwnedByUser : [];

       // project as member
       $projectAsMember = $user->projects()->get();
       $projectAsMember = !is_null($projectAsMember) ? $projectAsMember : [];

       // merge and get only unique
       $uniqueCollection = $projectOwnedByUser->merge($projectAsMember)->unique('name');

       return $uniqueCollection;
   }
}