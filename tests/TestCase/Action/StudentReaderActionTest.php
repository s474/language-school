<?php

namespace App\Test\TestCase\Action;

use App\Test\Fixture\StudentFixture;
use App\Test\Traits\AppTestTrait;
use Fig\Http\Message\StatusCodeInterface;
use PHPUnit\Framework\TestCase;
use Selective\TestTrait\Traits\DatabaseTestTrait;

/**
 * Test.
 *
 * @coversDefaultClass \App\Action\Student\StudentReaderAction
 */
class StudentReaderActionTest extends TestCase
{
    use AppTestTrait;
    use DatabaseTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testValidId(): void
    {
        $this->insertFixtures([StudentFixture::class]);
        $request = $this->createRequest('GET', '/students/1');
        $request = $this->withHttpBasicAuth($request);
        $response = $this->app->handle($request);        
        //fwrite(STDERR, print_r($response, TRUE));

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
        $this->assertJsonContentType($response);
        $this->assertJsonData(
            [
                'id' => 1,
                'name' => 'Joe',
                'surname' => 'Bloggs',
                'identification_no' => 'JB0001',
                'country' => 'US',
                'date_of_birth' => '2003-01-01 00:00:00',
                'registered_on' => '2021-01-01 00:00:00',
            ],
            $response
        );
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testInvalidId(): void
    {
        $request = $this->createRequest('GET', '/api/students/99');
        $request = $this->withHttpBasicAuth($request);
        $response = $this->app->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_NOT_FOUND, $response->getStatusCode());
    }
}
