<?php

namespace App\Services;

use App\Models\TicketStatus;
use Illuminate\Support\Collection;

class TicketStatusServices
{
    /**
     * @param $project
     * @return mixed
     */
    public static function generateTicketStatus($project)
    {
        $ticketStatus = TicketStatus::whereNull('project_id')
            ->orderBy('order', 'asc')
            ->orderBy('is_default', 'desc')
            ->pluck('name', 'id');

        if ($project->status_type == 'custom') {

            $ticketStatus = TicketStatus::where('project_id', $project->id)
                ->orderBy('order', 'asc')
                ->orderBy('is_default', 'desc')
                ->pluck('name', 'id');
        }

        return $ticketStatus;
    }

    public static function generateTicketGroup($user)
    {
        $projects = ProjectServices::getAllProjectByUser($user);
        $projectIds = !is_null($projects) ? $projects->pluck('id') : [];

        $ticketStatus = TicketStatus::whereIn('project_id', $projectIds)
            ->select('name')
            ->groupBy('name')
            ->get();

        return $ticketStatus;
    }
}