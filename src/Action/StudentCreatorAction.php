<?php

namespace App\Action;

use App\Domain\Student\Service\StudentCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class StudentCreatorAction
{
    private JsonRenderer $renderer;
    private $studentCreator;

    public function __construct(StudentCreator $studentCreator, JsonRenderer $renderer)
    {
        $this->studentCreator = $studentCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {
        
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $studentId = $this->studentCreator->createStudent($data);
        
        // Build the HTTP response
        return $this->renderer
            ->json($response, ['student_id' => $studentId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
