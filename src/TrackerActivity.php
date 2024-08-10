<?php

namespace Abdulbaset\TrackerActivity;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class TrackerActivity
{

    private static $retrieved = false;

    public static function setRetrieved($boolean = true)
    {
        self::$retrieved = $boolean;
    }

    public static function checkRetrieved()
    {
        return self::$retrieved;
    }
    
    public static function info($subject, $description = null, $properties = null)
    {
        if (!Config::get('tracker-activity.enabled')) {
            return false;
        }

        $logData = self::prepareLogData($type = 'info', $subject, null, $description, $properties);
        return self::logData($logData);
    }

    public static function visited($class = null, $description = null, $properties = null)
    {
        if (!Config::get('tracker-activity.enabled')) {
            return false;
        }

        $logData = self::prepareLogData($type = 'route', $subject = 'visited', $class, $description, $properties);
        return self::logData($logData);
    }

    public static function event($subject, $class, $description = null, $properties = null)
    {
        if (!Config::get('tracker-activity.enabled')) {
            return false;
        }

        $logData = self::prepareLogData($type = 'event', $subject, $class, $description, $properties);

        return self::logData($logData);
    }

    public static function model($subject, $class, $description = null, $properties = null)
    {
        if (!Config::get('tracker-activity.enabled')) {
            return false;
        }

        $logData = self::prepareLogData($type = 'model', $subject, $class, $description, $properties);

        return self::logData($logData);
    }

    public static function auth($subject, $class, $description = null, $properties = null)
    {
        if (!Config::get('tracker-activity.enabled')) {
            return false;
        }

        $logData = self::prepareLogData($type = 'auth', $subject, $class, $description, $properties);

        return self::logData($logData);
    }

    public static function exception($subject, $class, $description = null, $properties = null)
    {
        if (!Config::get('tracker-activity.enabled')) {
            return false;
        }

        $logData = self::prepareLogData(
            'exception',
            $subject,
            get_class($class),
            $description,
            array_merge(
                [
                    'exception' => [
                        'message' => $class->getMessage(),
                        'code' => $class->getCode(),
                        'file' => $class->getFile(),
                        'line' => $class->getLine()
                    ]
                ],
                $properties ?? []
            )
        );
        return self::logData($logData);
    }

    private static function prepareLogData($type, $subject, $class, $description, $properties)
    {
        $queryParameters = Request::query() ?? null;
        $headers = Request::header();

        $logData = [
            'type' => $type,
            'subject' => $subject,
            'auth_id' => Auth::id() ?: null,
            'class_name' => is_string($class) ? $class : ($class ? get_class($class) : null),
            'ip' => Request::ip(),
            'user_agent' => Request::header('User-Agent') ?? null,
            'query_parameters' => !empty($queryParameters) ? json_encode($queryParameters) : null,
            'request_method' => Request::method() ?? null,
            'headers' => !empty($headers) ? json_encode($headers) : null,
            'referring_url' => Request::server('HTTP_REFERER'),
            'current_url' => Request::fullUrl(),
            'description' => $description,
            'properties' => empty($properties) ? null : json_encode($properties),
            'created_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString(),
        ];

        return $logData;
    }

    protected static function logData($logData)
    {
        switch (config('tracker-activity.log_method')) {
            case 'file':
                return self::logToFile($logData);
            case 'database':
            default:
                return self::logToDatabase($logData);
        }
    }

    protected static function logToDatabase($logData)
    {
        return DB::table(config('tracker-activity.table_name'))->insert($logData) ? true : false;
    }

    protected static function logToFile($logData)
    {
        $logFilePath = config('tracker-activity.log_file_path');
        $logEntry = json_encode($logData) . PHP_EOL;
        return file_put_contents($logFilePath, $logEntry, FILE_APPEND) !== false;
    }
}
