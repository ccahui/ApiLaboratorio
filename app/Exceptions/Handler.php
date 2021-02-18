<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

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
        if ($exception instanceof ValidationException) {

            $response = $this->errorMessagesValidation($exception->errors());

            return response()->json($response, 400);
        }
        if ($exception instanceof ModelNotFoundException) {

            $response = $this->errorNotFoundModel($exception->getModel());

            return response()->json($response, 404);
        }

        return parent::render($request, $exception);
    }

    private function errorMessagesValidation($errors)
    {
        return [
            'ok' => false,
            'message' => "Validation Error.",
            'data' => $errors
        ];
    }
    // donde $model tiene la siguiente estructura App/Models/{Model}
    private function errorNotFoundModel($model)
    {
        $model = $this->onlyGetModel($model);
        return [
            'ok' => false,
            'message' => $model . " not found",
        ];
    }

    private function onlyGetModel($model)
    {
        $array = explode('\\', $model);
        $onlyModel = end($array);
        return $onlyModel;
    }
}
