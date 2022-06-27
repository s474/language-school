<?php

namespace App\Action;

use App\Renderer\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Yaml\Yaml;

final class HomeAction
{
    private TemplateRenderer $renderer;

    public function __construct(TemplateRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        $yamlFile = '/var/www/html/resources/api/language_school.yaml';
        $viewData = [
            'spec' => json_encode(Yaml::parseFile($yamlFile)),
        ];

        return $this->renderer->template($response, '/var/www/html/templates/swagger.php', $viewData);        
    }
}
