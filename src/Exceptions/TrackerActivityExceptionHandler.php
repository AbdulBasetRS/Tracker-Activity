<?php

namespace Abdulbaset\TrackerActivity\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Config;
use Abdulbaset\TrackerActivity\TrackerActivity;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\GoneHttpException;
use Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;
use Throwable;

class TrackerActivityExceptionHandler extends ExceptionHandler
{
    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $exception)
    {
        // Check for NotFoundHttpException
        if ($exception instanceof NotFoundHttpException) {
            if (Config::get('tracker-activity.exceptions.route_not_found', false)) {
                TrackerActivity::exception(
                    'route_not_found',
                    $exception,
                    'The requested route does not exist.',
                    $this->getRequestData($request)
                );
            }
        }

        // Check for UnauthorizedHttpException
        if ($exception instanceof UnauthorizedHttpException) {
            if (Config::get('tracker-activity.exceptions.unauthorized_exception', false)) {
                TrackerActivity::exception(
                    'unauthorized_exception',
                    $exception,
                    'Unauthorized access.',
                    $this->getRequestData($request)
                );
            }
        }

        // Check for MethodNotAllowedHttpException
        if ($exception instanceof MethodNotAllowedHttpException) {
            if (Config::get('tracker-activity.exceptions.method_not_allowed', false)) {
                TrackerActivity::exception(
                    'method_not_allowed',
                    $exception,
                    'Method not allowed.',
                    $this->getRequestData($request)
                );
            }
        }

        // Check for TooManyRequestsHttpException
        if ($exception instanceof TooManyRequestsHttpException) {
            if (Config::get('tracker-activity.exceptions.too_many_requests', false)) {
                TrackerActivity::exception(
                    'too_many_requests',
                    $exception,
                    'Too many requests.',
                    $this->getRequestData($request)
                );
            }
        }

        // Check for ConflictHttpException
        if ($exception instanceof ConflictHttpException) {
            if (Config::get('tracker-activity.exceptions.conflict_exception', false)) {
                TrackerActivity::exception(
                    'too_many_requests',
                    $exception,
                    'Conflict error.',
                    $this->getRequestData($request)
                );
            }
        }

        // Check for UnprocessableEntityHttpException
        if ($exception instanceof UnprocessableEntityHttpException) {
            if (Config::get('tracker-activity.exceptions.unprocessable_entity', false)) {
                TrackerActivity::exception(
                    'unprocessable_entity',
                    $exception,
                    'Unprocessable entity.',
                    $this->getRequestData($request)
                );
            }
        }

        // Check for AccessDeniedHttpException
        if ($exception instanceof AccessDeniedHttpException) {
            if (Config::get('tracker-activity.exceptions.access_denied', false)) {
                TrackerActivity::exception(
                    'access_denied',
                    $exception,
                    'Access denied.',
                    $this->getRequestData($request)
                );
            }
        }

        // Check for GoneHttpException
        if ($exception instanceof GoneHttpException) {
            if (Config::get('tracker-activity.exceptions.gone_exception', false)) {
                TrackerActivity::exception(
                    'gone_exception',
                    $exception,
                    'Resource gone.',
                    $this->getRequestData($request)
                );
            }
        }

        // Check for PreconditionFailedHttpException
        if ($exception instanceof PreconditionFailedHttpException) {
            if (Config::get('tracker-activity.exceptions.precondition_failed', false)) {
                TrackerActivity::exception(
                    'precondition_failed',
                    $exception,
                    'Precondition failed.',
                    $this->getRequestData($request)
                );
            }
        }

        // Check for UnsupportedMediaTypeHttpException
        if ($exception instanceof UnsupportedMediaTypeHttpException) {
            if (Config::get('tracker-activity.exceptions.unsupported_media_type', false)) {
                TrackerActivity::exception(
                    'unsupported_media_type',
                    $exception,
                    'Unsupported media type.',
                    $this->getRequestData($request)
                );
            }
        }

        // Log general HTTP exceptions if enabled
        if (Config::get('tracker-activity.exceptions.other_exceptions', false) && !$this->isHandledException($exception)) {
            TrackerActivity::exception(
                'general_exception',
                $exception,
                'An exception occurred: ' . get_class($exception),
                $this->getRequestData($request)
            );
        }

        return parent::render($request, $exception);
    }

    /**
     * Get request data for logging.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    private function getRequestData($request)
    {
        return [
            'body' => $request->all(),
        ];
    }

    /**
     * Check if the exception type is handled.
     *
     * @param \Throwable $exception
     * @return bool
     */
    private function isHandledException(Throwable $exception)
    {
        return $exception instanceof NotFoundHttpException ||
               $exception instanceof UnauthorizedHttpException ||
               $exception instanceof MethodNotAllowedHttpException ||
               $exception instanceof TooManyRequestsHttpException ||
               $exception instanceof ConflictHttpException ||
               $exception instanceof UnprocessableEntityHttpException ||
               $exception instanceof AccessDeniedHttpException ||
               $exception instanceof GoneHttpException ||
               $exception instanceof PreconditionFailedHttpException ||
               $exception instanceof UnsupportedMediaTypeHttpException;
    }
}
