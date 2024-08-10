<?php

// config/tracker-activity.php

return [
    /*
    |--------------------------------------------------------------------------
    | Tracker Activity  Enabled
    |--------------------------------------------------------------------------
    |
    | This value determines whether the tracker activity is enabled or disabled.
    | If set to true, activity logging will be enabled. If set to false, activity
    | logging will be disabled and no logs will be recorded.
    |
    */
    'enabled' => env('TRACKER_ACTIVITY_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Activity Log Table Name
    |--------------------------------------------------------------------------
    |
    | This value determines the name of the table that will store the activity
    | logs if the 'database' logging method is used. You can set this to any
    | table name that fits your application's requirements.
    |
    */
    'table_name' => 'activities',

    /*
    |--------------------------------------------------------------------------
    | Logging Method
    |--------------------------------------------------------------------------
    |
    | This value determines where the activity logs will be stored. You can
    | choose between 'database' and 'file'. If 'database' is selected, logs
    | will be stored in the table specified above. If 'file' is selected,
    | logs will be stored in the file specified by 'log_file_path'.
    |
    | Supported options: 'database', 'file'
    |
    */
    'log_method' => 'database',

    /*
    |--------------------------------------------------------------------------
    | Log File Path
    |--------------------------------------------------------------------------
    |
    | This value specifies the path to the file where activity logs will be
    | stored if the 'file' logging method is used. The path should be an
    | absolute path or a relative path from the storage directory.
    |
    */
    'log_file_path' => storage_path('logs/activities.log'),

    /*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    |
    | This configuration option defines the class name of the user model
    | used in the application. It is used to determine if the current model
    | being handled is the authenticated user. If you need to change the
    | user model, you can update this value, and it will be reflected
    | throughout the application wherever this setting is used.
    |
    */
    'user_model' => \App\Models\User::class,

    /*
    |--------------------------------------------------------------------------
    | Log Data Only Changes
    |--------------------------------------------------------------------------
    |
    | This value determines whether only the changes should be logged when an
    | entity is updated.
    |
    */
    'data_only_changes' => true,

    /*
    |--------------------------------------------------------------------------
    | Log HTTP Exceptions
    |--------------------------------------------------------------------------
    |
    | This option determines whether HTTP exceptions should be logged.
    | If set to true, HTTP exceptions will be logged. If set to false,
    | HTTP exceptions will not be logged.
    |
    | Each type of HTTP exception can be individually enabled or disabled.
    |
    */
    'exceptions' => [
        /*
        |--------------------------------------------------------------------------
        | Log NotFoundHttpException
        |--------------------------------------------------------------------------
        |
        | This option determines whether NotFoundHttpException should be logged.
        | If set to true, attempts to access non-existent routes will be logged.
        |
        */
        'route_not_found' => true,

        /*
        |--------------------------------------------------------------------------
        | Log UnauthorizedHttpException
        |--------------------------------------------------------------------------
        |
        | This option determines whether UnauthorizedHttpException should be logged.
        | If set to true, unauthorized access attempts will be logged.
        |
        */
        'unauthorized_exception' => true,

        /*
        |--------------------------------------------------------------------------
        | Log MethodNotAllowedHttpException
        |--------------------------------------------------------------------------
        |
        | This option determines whether MethodNotAllowedHttpException should be logged.
        | If set to true, attempts to use an incorrect HTTP method will be logged.
        |
        */
        'method_not_allowed' => true,

        /*
        |--------------------------------------------------------------------------
        | Log TooManyRequestsHttpException
        |--------------------------------------------------------------------------
        |
        | This option determines whether TooManyRequestsHttpException should be logged.
        | If set to true, too many requests from a client will be logged.
        |
        */
        'too_many_requests' => true,

        /*
        |--------------------------------------------------------------------------
        | Log ConflictHttpException
        |--------------------------------------------------------------------------
        |
        | This option determines whether ConflictHttpException should be logged.
        | If set to true, conflict errors during resource modification will be logged.
        |
        */
        'conflict_exception' => true,

        /*
        |--------------------------------------------------------------------------
        | Log UnprocessableEntityHttpException
        |--------------------------------------------------------------------------
        |
        | This option determines whether UnprocessableEntityHttpException should be logged.
        | If set to true, errors related to unprocessable entities will be logged.
        |
        */
        'unprocessable_entity' => true,

        /*
        |--------------------------------------------------------------------------
        | Log AccessDeniedHttpException
        |--------------------------------------------------------------------------
        |
        | This option determines whether AccessDeniedHttpException should be logged.
        | If set to true, access denied errors will be logged.
        |
        */
        'access_denied' => true,

        /*
        |--------------------------------------------------------------------------
        | Log GoneHttpException
        |--------------------------------------------------------------------------
        |
        | This option determines whether GoneHttpException should be logged.
        | If set to true, requests to resources that are no longer available will be logged.
        |
        */
        'gone_exception' => true,

        /*
        |--------------------------------------------------------------------------
        | Log PreconditionFailedHttpException
        |--------------------------------------------------------------------------
        |
        | This option determines whether PreconditionFailedHttpException should be logged.
        | If set to true, precondition failures during request processing will be logged.
        |
        */
        'precondition_failed' => true,

        /*
        |--------------------------------------------------------------------------
        | Log UnsupportedMediaTypeHttpException
        |--------------------------------------------------------------------------
        |
        | This option determines whether UnsupportedMediaTypeHttpException should be logged.
        | If set to true, unsupported media type errors will be logged.
        |
        */
        'unsupported_media_type' => true,

        /*
        |--------------------------------------------------------------------------
        | Log General HTTP Exceptions
        |--------------------------------------------------------------------------
        |
        | This option determines whether other HTTP exceptions should be logged.
        | If set to true, any HTTP exception not specifically mentioned above will be logged.
        |
        */
        'other_exceptions' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Event Types
    |--------------------------------------------------------------------------
    |
    | This section determines which types of events should be logged. You can
    | enable or disable logging for specific event types based on your needs.
    |
    */
    'events' => [
        /*
        |--------------------------------------------------------------------------
        | Authentication Events Logging
        |--------------------------------------------------------------------------
        |
        | This section determines whether various authentication events should be logged.
        | If set to true, each type of authentication event will be recorded. If set to false,
        | these events will not be logged.
        |
        | Each type of authentication event can be individually enabled or disabled.
        |
        */
        'auth_events' => [
            /*
            |--------------------------------------------------------------------------
            | Log Login Event
            |--------------------------------------------------------------------------
            |
            | This option determines whether the login event should be logged.
            | If set to true, user login events will be logged.
            |
            */
            'login' => true,

            /*
            |--------------------------------------------------------------------------
            | Log Logout Event
            |--------------------------------------------------------------------------
            |
            | This option determines whether the logout event should be logged.
            | If set to true, user logout events will be logged.
            |
            */
            'logout' => true,

            /*
            |--------------------------------------------------------------------------
            | Log Registered Event
            |--------------------------------------------------------------------------
            |
            | This option determines whether the registered event should be logged.
            | If set to true, user registration events will be logged.
            |
            */
            'registered' => true,

            /*
            |--------------------------------------------------------------------------
            | Log Login Failed Event
            |--------------------------------------------------------------------------
            |
            | This option determines whether the login failed event should be logged.
            | If set to true, failed login attempts will be logged.
            |
            */
            'failed' => true,

            /*
            |--------------------------------------------------------------------------
            | Log Email Verified Event
            |--------------------------------------------------------------------------
            |
            | This option determines whether the email verified event should be logged.
            | If set to true, user email verification events will be logged.
            |
            */
            'verified' => true,

            /*
            |--------------------------------------------------------------------------
            | Log Password Reset Event
            |--------------------------------------------------------------------------
            |
            | This option determines whether the password reset event should be logged.
            | If set to true, user password reset events will be logged.
            |
            */
            'password_reset' => true,

            /*
            |--------------------------------------------------------------------------
            | Log Lockout Event
            |--------------------------------------------------------------------------
            |
            | This option determines whether the lockout event should be logged.
            | If set to true, user lockout events will be logged.
            |
            */
            'lockout' => true,

            /*
            |--------------------------------------------------------------------------
            | Log Login Attempting Event
            |--------------------------------------------------------------------------
            |
            | This option determines whether the login attempting event should be logged.
            | If set to true, login attempt events will be logged.
            |
            */
            'attempting' => true,
        ],

        /*
        |--------------------------------------------------------------------------
        | Model Events Logging
        |--------------------------------------------------------------------------
        |
        | This section determines whether various model events should be logged.
        | If set to true, each type of model event will be recorded. If set to false,
        | these events will not be logged.
        |
        | Each type of model event can be individually enabled or disabled.
        |
        */
        'model_events' => [
            /*
            |--------------------------------------------------------------------------
            | Log Model Created Events
            |--------------------------------------------------------------------------
            |
            | This option determines whether model creation events should be logged.
            | If set to true, creation events will be recorded. If set to false,
            | creation events will not be logged.
            |
            */
            'created' => true,

            /*
            |--------------------------------------------------------------------------
            | Log Model Updated Events
            |--------------------------------------------------------------------------
            |
            | This option determines whether model update events should be logged.
            | If set to true, update events will be recorded. If set to false,
            | update events will not be logged.
            |
            */
            'updated' => true,

            /*
            |--------------------------------------------------------------------------
            | Log Model Deleted Events
            |--------------------------------------------------------------------------
            |
            | This option determines whether model deletion events should be logged.
            | If set to true, deletion events will be recorded. If set to false,
            | deletion events will not be logged.
            |
            */
            'deleted' => true,

            /*
            |--------------------------------------------------------------------------
            | Log Model Restored Events
            |--------------------------------------------------------------------------
            |
            | This option determines whether model restoration events should be logged.
            | If set to true, restoration events will be recorded. If set to false,
            | restoration events will not be logged.
            |
            */
            'restored' => true,

            /*
            |--------------------------------------------------------------------------
            | Log Model Force Deleted Events
            |--------------------------------------------------------------------------
            |
            | This option determines whether model force deletion events should be logged.
            | If set to true, force deletion events will be recorded. If set to false,
            | force deletion events will not be logged.
            |
            */
            'force_deleted' => true,
        ],
 
        /*
        |--------------------------------------------------------------------------
        | Log Route Events
        |--------------------------------------------------------------------------
        |
        | This section configures the logging of various route-related events in 
        | your application. You can control whether to log matched routes and 
        | attempts to access routes that are not found.
        |
        | Each option within this section allows you to specify whether or not to
        | log specific types of route events. This helps in monitoring, debugging, 
        | and maintaining an audit trail of route activities within your application.
        |
        */
        'route_events' => [
            /*
            |--------------------------------------------------------------------------
            | Log Route Matched
            |--------------------------------------------------------------------------
            |
            | This option determines whether route matched events should be logged.
            | If set to true, visits to matched routes will be logged.
            |
            */
            'route_matched' => true,
        ],
    ],

];
