<?php

namespace App\Models;

use App\Traits\HasUuid;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketStatus extends Model
{
    use HasUuid, SoftDeletes, HasFactory;

    public $table = 'ticket_statuses';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'uuid',
        'project_id',
        'name',
        'color',
        'order',
        'is_default',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
