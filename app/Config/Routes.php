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
$routes->setAutoRoute(false);

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
$routes->get('/admin/login', 'Admin/Login::index');
$routes->post('/admin/login/logar', 'Admin/Login::logar');

// CI 4.1 não resolve de forma confiável parâmetros em grupos aninhados.
// As rotas com ID ficam explícitas para preservar edição e exclusão.
$protected = ['filter' => 'routeFilter'];
$routes->get('admin/postagem/editar/(:num)', 'Admin\Postagem::editar/$1', $protected);
$routes->post('admin/postagem/salvar/(:num)', 'Admin\Postagem::salvar/$1', $protected);
$routes->post('admin/postagem/excluir/(:num)', 'Admin\Postagem::excluir/$1', $protected);
$routes->get('admin/pagina/editar/(:num)', 'Admin\Pagina::editar/$1', $protected);
$routes->post('admin/pagina/salvar/(:num)', 'Admin\Pagina::salvar/$1', $protected);
$routes->post('admin/pagina/excluir/(:num)', 'Admin\Pagina::excluir/$1', $protected);
$routes->get('admin/categoria/editar/(:num)', 'Admin\Categoria::editar/$1', $protected);
$routes->post('admin/categoria/salvar/(:num)', 'Admin\Categoria::salvar/$1', $protected);
$routes->post('admin/categoria/excluir/(:num)', 'Admin\Categoria::excluir/$1', $protected);



$routes->group("admin", ["filter" => "routeFilter"], function ($routes) {
    $routes->get('/', 'Admin/Dashboard::index');
    $routes->post('login/deslogar', 'Admin/Login::deslogar');
    $routes->get('aparencia', 'Admin/Aparencia::index');
    $routes->post('aparencia', 'Admin/Aparencia::salvar');

    $routes->group("postagem",  function ($routes) {
        $routes->get('/', 'Admin/Postagem::index');
        $routes->get('novo', 'Admin/Postagem::novo');
        $routes->post('salvar', 'Admin/Postagem::salvar');
    });

    $routes->group("pagina",  function ($routes) {
        $routes->get('/', 'Admin/Pagina::index');
        $routes->get('novo', 'Admin/Pagina::novo');
        $routes->post('salvar', 'Admin/Pagina::salvar');
    });

    $routes->group("categoria",  function ($routes) {
        $routes->get('/', 'Admin/Categoria::index');
        $routes->get('novo', 'Admin/Categoria::novo');
        $routes->post('salvar', 'Admin/Categoria::salvar');
    });
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
