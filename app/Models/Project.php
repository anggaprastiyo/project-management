<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\HasUuid;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Project extends Model implements HasMedia
{
    use HasUuid, SoftDeletes, InteractsWithMedia, Auditable, HasFactory;

    public $table = 'projects';

    public static $searchable = [
        'name',
    ];

    protected $appends = [
        'cover_image',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const TYPE_SELECT = [
        'kanban' => 'Kanban',
        'scrum'  => 'Scrum',
    ];

    public const TEAM_SELECT = [
        'internal' => 'Internal',
        'ad-hoc'   => 'Ad-Hoc',
    ];

    public const STATUS_TYPE_SELECT = [
        'default' => 'Default',
        'custom'  => 'Custom',
    ];

    protected $fillable = [
        'uuid',
        'team',
        'name',
        'ticket_prefix',
        'project_owner_id',
        'project_status_id',
        'description',
        'type',
        'status_type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function projectTickets()
    {
        return $this->hasMany(Ticket::class, 'project_id', 'id');
    }

    public function projectTicketStatuses()
    {
        return $this->hasMany(TicketStatus::class, 'project_id', 'id');
    }

    public function projectMeetingNotes()
    {
        return $this->hasMany(MeetingNote::class, 'project_id', 'id');
    }

    public function getCoverImageAttribute()
    {
        $file = $this->getMedia('cover_image')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function project_owner()
    {
        return $this->belongsTo(User::class, 'project_owner_id');
    }

    public function project_status()
    {
        return $this->belongsTo(ProjectStatus::class, 'project_status_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class);
    }
}
