<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    // customExceptionがあれば特殊ページを返す
    public function render($request, Throwable $exception)
    {
       if ($exception instanceof CustomException) {
        return response()->view('errors.custom', [
            "message"=>$exception->getMessage(),
        ],500);
       }
      return parent::render($request, $exception);
    }

}



