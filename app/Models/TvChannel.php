<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TvChannel extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider',
        'name',
        'slug',
        'logo_url',
        'description',
        'category',
        'stream_type',
        'stream_url',
        'embed_url',
        'external_url',
        'active',
        'sort_order',
    ];

    protected $casts = [
        'active' => 'boolean',
        'sort_order' => 'integer',
    ];
}