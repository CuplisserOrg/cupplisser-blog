<?php

namespace Cupplisser\Blog\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CComment extends Model
{
    use SoftDeletes;

    const STATUS_PENDING_APPROVAL = 'P';
    const STATUS_APPROVED = 'A';
    const STATUS_REJECTED = 'R';
    const STATUS_DELETED = 'D';
    const STATUS_SPAM = 'S';

    const STATUSES = [
        self::STATUS_PENDING_APPROVAL => 'Pending Approval',
        self::STATUS_APPROVED => 'Approved',
        self::STATUS_DELETED => 'Deleted',
        self::STATUS_REJECTED => 'Rejected',
        self::STATUS_SPAM => 'Spam',
    ];

    protected $table = "blog_comments";

    protected $fillable = [
        'post_id',
        'parent_id',
        'user_id',
        'name',
        'email',
        'body',
        'status',
        'moderated_by',
        'moderated_at',
    ];

    protected $casts = [
        'moderated_at' => "datetime",
        'created_at' => "datetime",
        'updated_at' => "datetime",
        'deleted_at' => "datetime",
    ];

    public function __construct()
    {
        $this->table = config('cblog.table.comments');
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function post()
    {
        return $this->belongsTo(BlogPost::class, "post_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function moderator()
    {
        return $this->belongsTo(User::class, "moderated_by");
    }

    public function replies()
    {
        return $this->hasMany(self::class, "parent_id", "id");
    }
}
