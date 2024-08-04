<?php

namespace Abdulbaset\TrackerActivity\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class TrackerActivity extends Model
{
    use HasFactory;

    protected $table = 'activities';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = Config::get('tracker-activity.table_name', 'activities');
    }

    protected $fillable = [
        'type',
        'subject',
        'auth_id',
        'class_name',
        'ip',
        'user_agent',
        'query_parameters',
        'request_method',
        'headers',
        'referring_url',
        'current_url',
        'description',
        'properties',
    ];

    protected $casts = [
        'query_parameters' => 'array',
        'headers' => 'array',
        'properties' => 'array',
    ];
}
