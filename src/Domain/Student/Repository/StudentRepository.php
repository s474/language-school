<?php

namespace App\Domain\Student\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class StudentRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }
    
    public function findStudents(array $student): array
    {    
        $query = $this->queryFactory->newSelect('students');

        $query->select(
            [
                'id',
                'name',
                'surname',
                'identification_no',
                'country',
                'date_of_birth',
                'registered_on',
            ]
        );
                
        $query->where(['name LIKE' => (isset($student['name']) ? $student['name'] . '%' : '%')]);
        // Add more conditions to the query
        // ...

        return $query->execute()->fetchAll('assoc') ?: [];
    }
    
    public function insertStudent(array $student): int
    {
        return (int)$this->queryFactory->newInsert('students', $this->toRow($student))
            ->execute()
            ->lastInsertId();
    }

    public function getStudentById(int $studentId): array
    {
        $query = $this->queryFactory->newSelect('students');
        $query->select(
            [
                'id',
                'name',
                'surname',
                'identification_no',
                'country',
                'date_of_birth',
                'registered_on',
            ]
        );

        $query->where(['id' => $studentId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Student not found: %s', $studentId));
        }

        return $row;
    }

    public function updateStudent(int $studentId, array $student): void
    {
        $row = $this->toRow($student);

        $this->queryFactory->newUpdate('students', $row)
            ->where(['id' => $studentId])
            ->execute();
    }

    public function existsStudentId(int $studentId): bool
    {
        $query = $this->queryFactory->newSelect('students');
        $query->select('id')->where(['id' => $studentId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    public function deleteStudentById(int $studentId): void
    {
        $this->queryFactory->newDelete('students')
            ->where(['id' => $studentId])
            ->execute();
    }

    private function toRow(array $student): array
    {
        return [
            'name' => $student['name'],
            'surname' => $student['surname'],
            'identification_no' => $student['identification_no'],
            'country' => $student['country'],
            'date_of_birth' => $student['date_of_birth'],
            'registered_on' => $student['registered_on'],
        ];
    }
}
