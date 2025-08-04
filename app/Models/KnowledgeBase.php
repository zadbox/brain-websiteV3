<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnowledgeBase extends Model
{
    protected $table = 'knowledge_base';

    protected $fillable = [
        'category',
        'question',
        'answer',
        'keywords',
        'context',
        'embedding',
        'priority',
    ];

    protected $casts = [
        'keywords' => 'array',
        'context' => 'array',
    ];
} 