<?php

use Slim\App;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

return function (App $app) {
    $app->get('/', \App\Action\HomeAction::class)->setName('home');
    $app->get('/students/{student_id}', \App\Action\StudentReaderAction::class);
    $app->get('/students', \App\Action\StudentFinderAction::class);    
    $app->post('/students', \App\Action\StudentCreatorAction::class);
    $app->put('/students/{student_id}', \App\Action\StudentUpdaterAction::class);
};
