<?php

namespace App\Action;

use App\Domain\Student\Service\StudentUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class StudentUpdaterAction
{
    private StudentUpdater $studentUpdater;

    private JsonRenderer $renderer;

    public function __construct(StudentUpdater $studentUpdater, JsonRenderer $jsonRenderer)
    {
        $this->studentUpdater = $studentUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        
        // Extract the form data from the request body
        $studentId = (int)$args['student_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $this->studentUpdater->updateStudent($studentId, $data);

        // Build the HTTP response
        return $this->renderer->json($response);
    }
}
