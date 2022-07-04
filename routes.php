<?php

use CMW\Controller\redirect\RedirectController;
use CMW\Router\Router;

require_once('lang/'.getenv("LOCALE").'.php');

/** @var $router Router Main router */

//Admin pages
$router->scope('/cmw-admin/redirect', function($router) {
    $router->get('/list', "redirect#frontRedirectListAdmin");

    $router->get('/add', "redirect#create");
    $router->post('/add', "redirect#createPost");

    $router->get('/edit/:id', function($id) {
        (new RedirectController)->edit($id);
    })->with('id', '[0-9]+');
    $router->post('/edit/:id', function($id) {
        (new RedirectController)->editPost($id);
    })->with('id', '[0-9]+');


    $router->get('/delete/:id', function($id) {
        (new RedirectController)->delete($id);
    })->with('id', '[0-9]+');
    $router->get('/delete/:id', function($id) {
        (new RedirectController)->delete($id);
    })->with('id', '[0-9]+');


    $router->get('/stats', "redirect#stats");

});


$router->scope('/cmw-admin/redirect/list', function($router) {

//Public redirect
    $router->scope('/r', function ($router){

        $router->get('/:slug', function($slug) {
            (new RedirectController)->redirect($slug);
        })->with('slug', '.*?');

    });

});