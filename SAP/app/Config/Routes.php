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
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/test', 'Home::test');

$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');
$routes->get('/index', 'Home::index');

$routes->get('/updateEmployees', 'Home::updateEmployees');
$routes->get('/returnToStaffPortal', 'Home::staffPortal');
$routes->get('/logout', 'Home::logout');
$routes->get('/hireEmployees', 'Home::hireEmployees');
$routes->get('/deactivateEmployees', 'Home::deactivateEmployees');

$routes->get('/manualHireEmployees', 'Home::Wrong_page');
$routes->post('/manualHireEmployees', 'Home::manualHireEmployees');

$routes->get('/advancedSearch', 'Home::Wrong_page');
$routes->post('/advancedSearch', 'Home::advancedSearch');

$routes->get('/confirmDeactivation', 'Home::Wrong_page');
$routes->post('/confirmDeactivation', 'Home::confirmDeactivation');

$routes->get('/manualDeactivateEmployees', 'Home::Wrong_page');
$routes->post('/manualDeactivateEmployees', 'Home::manualDeactivateEmployees');

$routes->get('/updateSearch', 'Home::Wrong_page');
$routes->post('/updateSearch', 'Home::updateSearch');

$routes->get('/submitUpdate', 'Home::Wrong_page');
$routes->post('/submitUpdate', 'Home::submitUpdate');

$routes->get('/Hall_Director', 'Home::Hall_Director');
$routes->post('/RemoveHD', 'Home::RemoveHD');

$routes->get('/viewNotifications', 'Home::viewNotifications');
$routes->post('/closeNotification', 'Home::closeNotification');

$routes->get('/Notifications', 'Home::Notifications');
$routes->post('/addNotification', 'Home::addNotification');
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
