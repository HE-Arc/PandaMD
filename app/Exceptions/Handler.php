<?php

namespace App\Exceptions;

use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof AuthorizationException) {
            if (Auth::check()) {
                return redirect()->back()->with('error', 1)->setStatusCode(404); // this will be on a 403 exception
            }
        }
        if ($exception instanceof ModelNotFoundException) {
            return redirect()->route('home')->with('error', 5)->setStatusCode(404); //Resource not found
        }
        //session(['error' => 10]);
        if($exception instanceof  \Illuminate\Validation\ValidationException) {
            //$exce = $exception as \Illuminate\Validation\ValidationException::class;
            error_log($exception);
        }
        //error_log($exception);
        return parent::render($request, $exception);
    }
}
