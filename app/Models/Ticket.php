<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Ticket extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable, HasFactory;

    public $table = 'tickets';

    protected $appends = [
        'attachment',
    ];

    public static $searchable = [
        'code',
        'name',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'uuid',
        'project_id',
        'code',
        'name',
        'reporter_id',
        'assigne_id',
        'label',
        'status_id',
        'type_id',
        'priority_id',
        'content',
        'point',
        'design_link',
        'related_ticket_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($ticket) {
            $ticket->uuid = Uuid::uuid4()->toString();
            $ticket->code = $ticket->generateCode();
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function ticketComments()
    {
        return $this->hasMany(Comment::class, 'ticket_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function assigne()
    {
        return $this->belongsTo(User::class, 'assigne_id');
    }

    public function status()
    {
        return $this->belongsTo(TicketStatus::class, 'status_id');
    }

    public function type()
    {
        return $this->belongsTo(TicketType::class, 'type_id');
    }

    public function priority()
    {
        return $this->belongsTo(TicketPriority::class, 'priority_id');
    }

    public function getAttachmentAttribute()
    {
        return $this->getMedia('attachment');
    }

    public function related_ticket()
    {
        return $this->belongsTo(self::class, 'related_ticket_id');
    }

    public function generateCode()
    {
        $prefix = $this->project->ticket_prefix;
        $count = Ticket::where('project_id', $this->project_id)->count();
        $code = $prefix . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
        return $code;
    }
}
