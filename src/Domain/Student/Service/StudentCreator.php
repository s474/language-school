<?php

namespace App\Domain\Student\Service;

use App\Domain\Student\Repository\StudentRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class StudentCreator
{   
    private StudentRepository $repository;

    private StudentValidator $studentValidator;

    private LoggerInterface $logger;    
    
    public function __construct(
        StudentRepository $repository,
        StudentValidator $studentValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->studentValidator = $studentValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('student_creator.log')
            ->createLogger();
    }
    
    public function createStudent(array $data): int
    {
        // Input validation
        $this->studentValidator->validateStudent($data);

        // Insert student
        $studentId = $this->repository->insertStudent($data);

        // Logging
        $this->logger->info(sprintf('Student created successfully: %s', $studentId));
        
        return $studentId;
    }    
}
