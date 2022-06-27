<?php

namespace App\Domain\Student\Service;

use App\Domain\Student\Data\StudentReaderResult;
use App\Domain\Student\Repository\StudentRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class StudentReader
{
    private $repository;

    public function __construct(StudentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getStudentDetails(int $studentId): StudentReaderResult
    {
        // Input validation
        if (empty($studentId)) {
            throw new ValidationException('Student ID required');
        }

        $studentRow = $this->repository->getStudentById($studentId);

        // Map array to data object
        $student = new StudentReaderResult();
        $student->id = (int)$studentRow['id'];
        $student->name = (string)$studentRow['name'];
        $student->surname = (string)$studentRow['surname'];
        $student->identification_no = (string)$studentRow['identification_no'];
        $student->country = (string)$studentRow['country'];
        $student->date_of_birth = (string)$studentRow['date_of_birth'];
        $student->registered_on = (string)$studentRow['registered_on'];
        return $student;
    }
}