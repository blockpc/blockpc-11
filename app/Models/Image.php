<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

final class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::deleting(function ($image) {
    //         $path = str_replace('storage', 'public', $image->url);
    //         Storage::delete($path);
    //     });
    // }

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
