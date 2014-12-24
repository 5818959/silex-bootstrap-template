<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/app.php';

// create app
$app = new Silex\Application();

// enable debug
$app['debug'] = true;

// register Twig
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views',
));
// register Url Generator
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

// http error handler example
$app->error(function (Exception $e, $code) use ($app) {
    if ($code == 404) {
        return $app['twig']->render('error/404.html.twig', array('code' => 404));
    }
    return $app['twig']->render('error/default.html.twig', array('code' => $code));
});

// create routes
$routes = array(
    'home' => array(
        'url' => '/',
        'template' => 'home/index.html.twig',
        'data' => array(),
    ),
);
foreach ($routes as $routeName => $data) {
    $app->get($data['url'], function () use ($app, $data) {
        return $app['twig']->render($data['template'], $data['data']);
    })->bind($routeName);
}

// run app
$app->run();
