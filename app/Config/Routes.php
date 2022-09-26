<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/post/(:any)', 'Post::index/$1');
$routes->get('/categoria/(:any)', 'Home::categoria/$1');
$routes->get('/pagina/(:any)', 'Pagina::index/$1');
$routes->get('/pesquisar', 'Home::pesquisa');
$routes->post('/pesquisar', 'Home::pesquisa');
$routes->add('/admin/login', 'Admin/Login::index');



$routes->group("admin", ["filter" => "routeFilter"], function ($routes) {
    $routes->add('/', 'Admin/Dashboard::index');

    $routes->add('postagem', 'Admin/Postagem::index');
    $routes->add('postagem/novo', 'Admin/Postagem::novo');
    $routes->add('postagem/editar', 'Admin/Postagem::editar');
    $routes->add('postagem/salvar', 'Admin/Postagem::salvar');
    $routes->add('postagem/excluir', 'Admin/Postagem::excluir');
    

    $routes->add('pagina', 'Admin/Pagina::index');
    $routes->add('pagina/novo', 'Admin/Pagina::novo');
    $routes->add('pagina/editar', 'Admin/Pagina::editar');
    $routes->add('pagina/salvar', 'Admin/Pagina::salvar');
    $routes->add('pagina/excluir', 'Admin/Pagina::excluir');
});
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
