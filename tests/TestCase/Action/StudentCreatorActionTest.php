<?php

namespace App\Test\TestCase\Action;

use App\Test\Traits\AppTestTrait;
use Fig\Http\Message\StatusCodeInterface;
use PHPUnit\Framework\TestCase;
use Selective\TestTrait\Traits\DatabaseTestTrait;

/**
 * Test.
 *
 * @coversDefaultClass \App\Action\StudentCreatorAction
 */
class StudentCreatorActionTest extends TestCase
{
    use AppTestTrait;
    use DatabaseTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testCreateStudent(): void
    {   
        $request = $this->createJsonRequest(
            'POST',
            '/students',
            [
                'name' => 'Testname',
                'surname' => 'Testsurname',
                'identification_no' => 'TEST0001',
                'country' => 'GB',
                'date_of_birth' => '1974-01-01 00:00:00',
                'registered_on' => '2021-01-01 00:00:00',                
            ]
        );
        $request = $this->withHttpBasicAuth($request);
        $response = $this->app->handle($request);
        
        // Check response        
        $this->assertSame(StatusCodeInterface::STATUS_CREATED, $response->getStatusCode());
        $this->assertJsonContentType($response);
        $this->assertJsonData(['student_id' => 1], $response);

        // Check logger
        $this->assertTrue($this->getLogger()->hasInfoThatContains('Student created successfully'));

        // Check database
        $this->assertTableRowCount(1, 'students');

        $expected = [
            'id' => '1',
            'name' => 'Testname',
            'surname' => 'Testsurname',
            'identification_no' => 'TEST0001',
            'country' => 'GB',
            'date_of_birth' => '1974-01-01 00:00:00',
            'registered_on' => '2021-01-01 00:00:00', 
        ];

        $this->assertTableRow($expected, 'students', 1);
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testCreateStudentValidation(): void
    {
        $request = $this->createJsonRequest(
            'POST',
            '/students',
            [
                'name' => '',
                'surname' => '',
                'identification_no' => '',
                'country' => '',
                'date_of_birth' => '',
                'registered_on' => '',                
            ]
        );
        $request = $this->withHttpBasicAuth($request);
        $response = $this->app->handle($request);

        // Check response
        $this->assertSame(StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->assertJsonContentType($response);

        $expected = [
            'error' => [
                'message' => 'Please check your input',
                'details' => [
                    [
                        'message' => 'This value should not be blank.',
                        'field' => '[identification_no]',
                    ],
                    [
                        'message' => 'This value should be positive.',
                        'field' => '[identification_no]',
                    ],
                    [
                        'message' => 'This value should not be blank.',
                        'field' => '[name]',
                    ],
                    [
                        'message' => 'This value should not be blank.',
                        'field' => '[surname]',
                    ],
                    [
                        'message' => 'This value should not be blank.',
                        'field' => '[country]',
                    ],
                    [
                        'message' => 'This value should have exactly 2 characters.',
                        'field' => '[country]',
                    ],
                ],
            ],
        ];
        $this->assertJsonData($expected, $response);
    }

}
