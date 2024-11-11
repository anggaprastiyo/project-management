<?php

namespace App\Services;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Collection;

class UserServices
{
    /**
     * @param $type
     * @param $userUnitCode
     * @return Collection
     */
    public static function generateProjectMember($type, $userUnitCode, $projectId = null)
    {
        // get members
        $members = User::where('unit_code', '!=', '')
            ->whereNull('deleted_at')
            ->orderBy('unit_code', 'asc')
            ->orderBy('nik', 'asc')
            ->get();

        if ($type == 'internal') {
            $members = $members->where('unit_code', $userUnitCode);
        }

        if (!is_null($projectId)) {
            $project = Project::where('id', $projectId)->first();
            $memberIds = $project->members()->pluck('id');
            $members = $members->whereIn('id', $memberIds);
        }

        $members = $members->groupBy('unit_name');

        $result = collect();
        foreach ($members as $key => $member) {

            $itemMember = collect();
            foreach ($member as $item) {
                $itemMember->push(collect()
                    ->put('id', $item->id)
                    ->put('nik', $item->nik)
                    ->put('job_position_text', ucwords(strtolower($item->job_position_text)))
                    ->put('name', $item->name));
            }

            $result->push(collect()
                ->put('text', $key)
                ->put('children', $itemMember));
        }

        return $result;
    }
}