<?php

namespace App\Action;

use App\Domain\Student\Data\StudentFinderResult;
use App\Domain\Student\Service\StudentFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class StudentFinderAction
{
    private StudentFinder $studentFinder;
    private JsonRenderer $renderer;

    public function __construct(StudentFinder $studentFinder, JsonRenderer $jsonRenderer)
    {
        $this->studentFinder = $studentFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Collect input from the HTTP request
        $data = (array)$request->getQueryParams();
        $students = $this->studentFinder->findStudents($data);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($students));
        
        // Build the HTTP response
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);        
    }

    public function transform(StudentFinderResult $result): array
    {
        $students = [];

        foreach ($result->students as $student) {
            $students[] = [
                'id' => $student->id,
                'name' => $student->name,
                'surname' => $student->surname,
                'identification_no' => $student->identification_no,
                'country' => $student->country,
                'date_of_birth' => $student->date_of_birth,
                'registered_on' => $student->registered_on,
            ];
        }

        return [
            'students' => $students,
        ];
    }
}
