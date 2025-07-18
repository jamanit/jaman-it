<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SettingItem extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'uuid',
        'setting_id',
        'name',
        'key',
        'type',
        'value',
        'value_file',
    ];

    public $incrementing = true;

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function newUniqueId(): string
    {
        return (string) Uuid::uuid7();
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function setting()
    {
        return $this->belongsTo(Setting::class, 'setting_id', 'uuid');
    }

    protected static function booted()
    {
        static::updating(function ($model) {
            if ($model->isDirty('value')) {
                $oriPathOld = $model->getOriginal('value');
                $thumbPathOld = 'thumbs/' . $oriPathOld;
                $oriPathNew = $model->value;
                if ($oriPathOld && $oriPathOld !== $oriPathNew && self::isPathFile($oriPathOld)) {
                    if (Storage::disk('public')->exists($oriPathOld)) {
                        Storage::disk('public')->delete($oriPathOld);
                    }
                    if (Storage::disk('public')->exists($thumbPathOld)) {
                        Storage::disk('public')->delete($thumbPathOld);
                    }
                }
            }
        });

        static::deleting(function ($model) {
            if ($model->value) {
                $oriPath = $model->value;
                $thumbPath = 'thumbs/' . $oriPath;
                if (Storage::disk('public')->exists($oriPath)) {
                    Storage::disk('public')->delete($oriPath);
                }
                if (Storage::disk('public')->exists($thumbPath)) {
                    Storage::disk('public')->delete($thumbPath);
                }
            }
        });
    }

    protected static function isPathFile($path): bool
    {
        return is_string($path) && preg_match('/\.(jpg|jpeg|png|gif|webp|svg|bmp|ico|tiff|psd|ai|eps|heic|pdf|doc|docx|xls|xlsx|ppt|pptx|txt|csv|json|xml|mp4|mov|mkv|avi|wmv|webm|mp3|wav|ogg|flac|zip|rar|7z|tar|gz|apk|exe|msi)$/i', $path);
    }
}
