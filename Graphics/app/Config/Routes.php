<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
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
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/test', 'Home::test');
$routes->get('/error', 'Home::error');

$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');
$routes->get('/test2', 'Home::test2');

$routes->get('/Pview/(:any)', 'Home::Pview/');
$routes->get('/Gview/(:any)', 'Home::Gview/');

$routes->post('/assignedTo', 'Home::assignedTo');
$routes->post('/requestStatus', 'Home::requestStatus');
$routes->post('/Completed', 'Home::Completed');

$routes->post('/home/assignedTo', 'Home::assignedTo');
$routes->post('/home/requestStatus', 'Home::requestStatus');
$routes->post('/home/Completed', 'Home::Completed');

$routes->post('/P_assignedTo', 'Home::P_assignedTo');
$routes->post('/P_requestStatus', 'Home::P_requestStatus');
$routes->post('/P_Completed', 'Home::P_Completed');

$routes->post('/home/P_assignedTo', 'Home::P_assignedTo');
$routes->post('/home/P_requestStatus', 'Home::P_requestStatus');
$routes->post('/home/P_Completed', 'Home::P_Completed');

$routes->get('/form_print', 'Home::form_print');
$routes->post('/form_print', 'Home::form_print');

$routes->get('/form_graph', 'Home::form_graph');
$routes->post('/form_graph', 'Home::form_graph');
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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
