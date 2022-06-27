<?php

namespace App\Test\Fixture;

/**
 * Fixture.
 */
class StudentFixture
{
    public string $table = 'students';

    public array $records = [
        [
            'id' => '1',
            'name' => 'Joe',
            'surname' => 'Bloggs',
            'identification_no' => 'JB0001',
            'country' => 'US',
            'date_of_birth' => '2003-01-01 00:00:00',
            'registered_on' => '2021-01-01 00:00:00',
        ],
        [
            'id' => '2',
            'name' => 'Jane',
            'surname' => 'Bloggs',
            'identification_no' => 'JB0002',
            'country' => 'US',
            'date_of_birth' => '2004-04-04 00:00:00',
            'registered_on' => '2021-01-01 00:00:00',
        ],
    ];
}
