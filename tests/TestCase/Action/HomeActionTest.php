<?php

namespace App\Test\TestCase\Action;

use App\Test\Traits\AppTestTrait;
use Fig\Http\Message\StatusCodeInterface;
use PHPUnit\Framework\TestCase;

class HomeActionTest extends TestCase
{
    use AppTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testAction(): void
    {
        $request = $this->createRequest('GET', '/');
        $response = $this->app->handle($request);                
        $this->assertStringContainsString('<div id="swagger-ui"></div>', (string)$response->getBody());
        $this->assertStringContainsString('Language School API', (string)$response->getBody());
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }

    /**
     * Test invalid link.
     *
     * @return void
     */
    public function testPageNotFound(): void
    {
        $request = $this->createRequest('GET', '/nada');
        $response = $this->app->handle($request);
        $this->assertSame(StatusCodeInterface::STATUS_NOT_FOUND, $response->getStatusCode());
    }
}
