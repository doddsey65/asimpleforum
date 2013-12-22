<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app->get('/', function (Application $app) {
    return Route::get('home:index');
});

$app->get('/test', function (Application $app) {
    return include 'test.php';
});

$app->get('/signup', function (Application $app) {
    return Route::get('auth:signup');
});

$app->post('/signup', function (Request $request) {
    return Route::get('auth:signup', $request);
});

$app->post('/login', function (Request $request) use ($app) {
    return $app['auth']->login($request);
});

$app->get('/logout', function (Application $app) {
    return Route::get('auth:logout');
});

$app->get('/user/{username}', function (Application $app, $username) {
    return Route::get('user:index', $username);
});

$app->post('/partial/{name}', function (Request $request, $name) use ($app) {

    $params = $request->get('params');
    $array = array();

    if (isset($params) && is_array($params))
    {
        foreach ($params as $key => $param)
        {
            $array[$key] = $param;
        
        }
    }

    $array['user'] = $app['session']->get('user');

    return $app['twig']->render('Partials/' . $name . '.twig', $array);
});

$app->get('/partial/{name}', function (Application $app, $name) {
    return $app['twig']->render('Partials/' . $name . '.twig', array(
        'user' => $app['session']->get('user')
    ));
});

$app->get('/{name}-{id}/{page}', function (Application $app, $name, $id, $page) {
    return Route::get('forum:index', $name, $id, $page);
})->assert('page', '([0-9]+)');

$app->get('/{name}-{id}', function (Application $app, $name, $id) {
    return Route::get('forum:index', $name, $id);
});

$app->get('/{forum_name}/{topic_name}-{topic_id}/{page}', function (Application $app, $topic_name, $topic_id, $page) {
    return Route::get('topic:index', $topic_name, $topic_id, $page);
})->assert('page', '([0-9]+)');

$app->get('/{forum_name}/{topic_name}-{topic_id}', function (Application $app, $topic_name, $topic_id) {
    return Route::get('topic:index', $topic_name, $topic_id);
});

$app->post('/topic/{method}', function (Request $request, $method) use ($app) {
    if (!method_exists($app['topic'], $method))
    {
        $response = new Response();
        $response->setStatusCode(403);
        return $response;
    }
    return $app['topic']->$method($request);
});

$app->post('/post/{method}', function (Request $request, $method) use ($app) {
    if (!method_exists($app['post'], $method))
    {
        $response = new Response();
        $response->setStatusCode(403);
        return $response;
    }
    return $app['post']->$method($request);
});