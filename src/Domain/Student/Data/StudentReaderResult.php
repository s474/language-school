<?php

namespace App\Domain\Student\Data;

final class StudentReaderResult
{
    /**
     * @var int
     */
    public $id;

    /** @var string */
    public $name;

    /** @var string */
    public $surname;

    /** @var string */
    public $identification_no;

    /** @var string */
    public $country;
    
    /** @var string */
    public $date_of_birth;    
    
    /** @var string */
    public $registered_on;    
}