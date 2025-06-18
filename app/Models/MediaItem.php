<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MediaItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'parent_id',
        'path',
        'mime_type',
        'size',
        'user_id',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MediaItem::class, 'parent_id');
    }

   
    public function children(): HasMany
    {
        return $this->hasMany(MediaItem::class, 'parent_id');
    }

 
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

   
    public function scopeOnlyFolders($query)
    {
        return $query->where('type', 'folder');
    }

    
    public function scopeOnlyFiles($query)
    {
        return $query->where('type', 'file');
    }
}
