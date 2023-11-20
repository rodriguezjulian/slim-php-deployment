<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class RequestLoggerMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        // Registro de la solicitud
        $this->logRequest($request);

        // Continúa al siguiente middleware o controlador
        $response = $handler->handle($request);

        // Puedes realizar acciones después de que se maneje la solicitud si es necesario

        return $response;
    }

    private function logRequest(Request $request)
    {
        $method = $request->getMethod();
        $uri = $request->getUri();
        $date = date('Y-m-d H:i:s');

        // Aquí puedes ajustar el formato del registro según tus necesidades
        $logMessage = "[$date] [$method] $uri";

        // Puedes almacenar $logMessage en un archivo de registro, enviarlo a una base de datos, etc.
        // Por ahora, simplemente lo mostraré en la consola.
        error_log($logMessage);
    }
}
?>