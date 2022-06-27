<?php

namespace App\Domain\Student\Service;

use App\Domain\Student\Repository\StudentRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class StudentValidator
{
    private StudentRepository $repository;

    public function __construct(StudentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateStudentUpdate(int $studentId, array $data): void
    {
        if (!$this->repository->existsStudentId($studentId)) {
            throw new DomainException(sprintf('Student not found: %s', $studentId));
        }

        $this->validateStudent($data);
    }

    public function validateStudent(array $data): void
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($data, $this->createConstraints());

        if ($violations->count()) {
            throw new ValidationFailedException('Please check your input', $violations);
        }
    }

    private function createConstraints(): Constraint
    {
        $constraint = new ConstraintFactory();

        return $constraint->collection(
            [
                'identification_no' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(null, 8),
                        $constraint->positive(),
                    ]
                ),
                'name' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(null, 255),
                    ]
                ),
                'surname' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(null, 255),
                    ]
                ),
                'country' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(2, 2),
                    ]
                ),
                'date_of_birth' => $constraint->required(
                    [
                        $constraint->datetime(),
                    ]
                ),
                'registered_on' => $constraint->required(
                    [
                        $constraint->datetime(),
                    ]
                ),                
            ]
        );
    }
}
