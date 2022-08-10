<?php

namespace App\Exceptions;

use Exception;
use App\Traits\ApiResponser;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    use ApiResponser; 
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
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
            return $this->convertValidationExceptionToResponse($exception, $request);
        } //fin if-validationException 

        if ($exception instanceof ModelNotFoundException) {
            $modelo = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse("No existe ninguna instancia de {$modelo} con el id especificado",404); 
        }//fin de if-ModelNotFound 

        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request,$exception);
        }//fin de if-authenticationException     

        if ($exception instanceof AuthorizationException) {
            return $this->errorResponse('No posee permisos para ejecutar esta accion', 403);
        }//fin de if-authorizationException 

        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse('No se encontro la URL especificada', 404);
        }//fin de if-notfoundHttpException            

        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse('El metodo especificado en la peticion no es valido', 405);
        }//fin de if-method...Exception

        if ($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(), $exception->getStatusaCode());
        }//fin de if-HttpException 

        if ($exception instanceof QueryException) {
            $codigo = $exception->errorInfo[1];

            if($codigo == 1451){
                return $this->errorResponse('No se puede eliminar de forma permanente el recurso porque esta relacionado con algun otro', 409);
            }

        }//fin de if-QueryException         

        if(config('app.debug')){
            return parent::render($request, $exception);
        }//fin de if-config
        
        return $this->errorResponse('falla inesperada, intenta luego', 500);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return $this->errorResponse('No autenticado.', 401);
        }
    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function converttValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();
        return $this->errorResponse($errors, 422);
    }
}
