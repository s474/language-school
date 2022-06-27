<?php

namespace App\Domain\Student\Service;

use App\Domain\Student\Repository\StudentRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class StudentUpdater
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
            ->addFileHandler('student_updater.log')
            ->createLogger();
    }

    public function updateStudent(int $studentId, array $data): void
    {
        // Input validation
        $this->studentValidator->validateStudentUpdate($studentId, $data);

        // Update the row
        $this->repository->updateStudent($studentId, $data);

        // Logging
        $this->logger->info(sprintf('Student updated successfully: %s', $studentId));
    }
}
