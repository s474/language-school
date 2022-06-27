<?php

namespace App\Action;

use App\Domain\Student\Data\StudentReaderResult;
use App\Domain\Student\Service\StudentReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class StudentReaderAction
{
    private StudentReader $studentReader;
    private JsonRenderer $renderer;

    public function __construct(StudentReader $studentReader, JsonRenderer $jsonRenderer)
    {
        $this->studentReader = $studentReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $studentId = (int)$args['student_id'];

        // Invoke the domain and get the result
        $student = $this->studentReader->getStudentDetails($studentId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($student));
        
        // Build the HTTP response
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    private function transform(StudentReaderResult $student): array
    {
        return [
            'id' => $student->id,
            'name' => $student->name,
            'surname' => $student->surname,
            'identification_no' => $student->identification_no,
            'country' => $student->country,
            'date_of_birth' => $student->date_of_birth,
            'registered_on' => $student->registered_on,
        ];
    }
}
