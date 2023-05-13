<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

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
$routes->get('/error', 'Home::error');
$routes->get('/test', 'Home::test');

// Home
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');
$routes->post('/getStudent', 'Home::getStudent');
$routes->post('/getVisitor', 'Home::getVisitor');
$routes->post('/cleardata', 'Home::cleardata');
$routes->post('/signIn', 'Home::signIn');
$routes->get('/showStudentGuests', 'Home::showStudentGuests');
$routes->get('/signOut', 'Home::signOut');

// Guest
$routes->get('/guests', 'Home::guests');

// Service
$routes->get('/service', 'Service::index');
$routes->get('/serviceLog', 'Service::serviceLog');
$routes->get('/SignOutService', 'Service::SignOutService');
$routes->post('/ServiceIn', 'Service::ServiceIn');

// package
$routes->get('/package', 'Package::index');
$routes->get('/viewPackageLogOnly', 'Package::viewPackageLogOnly');
$routes->get('/GetSearchSelectedStudent', 'Package::GetSearchSelectedStudent');
$routes->post('/searchStudent', 'Package::searchStudent');
$routes->post('/registerPackage', 'Package::registerPackage');
$routes->get('/checkOutPackage', 'Package::checkOutPackage');

// Equipment
$routes->get('/Equipment', 'Equipment::index');
$routes->post('/EquipmentLog', 'Equipment::EquipmentLog');
$routes->get('/EquipmentLog', 'Equipment::EquipmentLog');
$routes->get('/returnEquipment', 'Equipment::returnEquipment');
$routes->post('/checkOutEquipment', 'Equipment::checkOutEquipment');

// Keys
$routes->get('/key', 'Key::index');
$routes->get('/KeyLog', 'Key::KeyLog');
$routes->post('/KeyLog', 'Key::KeyLog');
$routes->get('/returnKey', 'Key::returnKey');
$routes->post('/checkOutKey', 'Key::checkOutKey');

// Time Clock
$routes->get('/clock', 'Clock::index');
$routes->post('/clockIn', 'Clock::clockIn');
$routes->post('/staff', 'Clock::staff');

// Fails
$routes->get('/showFailed', 'Fails::index');
$routes->post('/regularFails', 'Fails::regular');
$routes->post('/overnightFails', 'Fails::overnight');
$routes->get('/var', 'Fails::var');

// Banned List
$routes->get('/showBannedList', 'Home::showBannedList');

// support
$routes->get('/support', 'Support::index');
$routes->post('/getSupport', 'Support::getSupport');
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
