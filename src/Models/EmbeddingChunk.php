<?php

namespace Ariefadjie\Laravai\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EmbeddingChunk extends Model
{
    use HasFactory;

    protected $primaryKey = 'guid';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'text',
        'vector',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->guid = Str::orderedUuid();
        });
    }
}
