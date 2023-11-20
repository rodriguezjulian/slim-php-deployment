<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class JsonMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);

        // Verificar si el contenido ya es de tipo JSON
        $contentType = $response->getHeaderLine('Content-Type');
        if (empty($contentType) || strpos($contentType, 'json') === false) {
            // Si no es JSON, establecer el encabezado 'Content-Type' en 'application/json'
            $response = $response->withHeader('Content-Type', 'application/json');
        }
        return $response;
    }
}
?>