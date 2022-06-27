<?php

namespace App\Domain\Student\Service;

use App\Domain\Student\Data\StudentFinderItem;
use App\Domain\Student\Data\StudentFinderResult;
use App\Domain\Student\Repository\StudentRepository;

final class StudentFinder
{
    private StudentRepository $repository;

    public function __construct(StudentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findStudents(array $students): StudentFinderResult
    {
        // Input validation
        // ...

        $students = $this->repository->findStudents($students);

        return $this->createResult($students);
    }

    private function createResult(array $studentRows): StudentFinderResult
    {
        $result = new StudentFinderResult();

        foreach ($studentRows as $studentRow) {
            $student = new StudentFinderItem();
            $student->id = $studentRow['id'];
            $student->name = $studentRow['name'];
            $student->surname = $studentRow['surname'];
            $student->identification_no = $studentRow['identification_no'];
            $student->country = $studentRow['country'];
            $student->date_of_birth = $studentRow['date_of_birth'];
            $student->registered_on = $studentRow['registered_on'];
            
            $result->students[] = $student;
        }

        return $result;
    }
}
