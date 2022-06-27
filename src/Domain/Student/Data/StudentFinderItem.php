<?php

namespace App\Domain\Student\Data;

/**
 * Data Transfer Object
 */
final class StudentFinderItem
{
    public ?int $id = null;

    public ?string $name = null;

    public ?string $surname = null;

    public ?string $identification_no = null;

    public ?string $country = null;
    
    public ?string $date_of_birth = null;
    
    public ?string $registered_on = null;
}
