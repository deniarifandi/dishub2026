<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

//VA OWNER START
$routes->get('va-owner', 'VaOwnerController::index');
$routes->get('va-owner/create', 'VaOwnerController::create');
$routes->post('va-owner/store', 'VaOwnerController::store');
$routes->get('va-owner/edit/(:num)', 'VaOwnerController::edit/$1');
$routes->post('va-owner/update/(:num)', 'VaOwnerController::update/$1');
$routes->get('va-owner/delete/(:num)', 'VaOwnerController::delete/$1');

$routes->post('va-owner/data', 'VaOwnerController::data');

//transaksi START
$routes->get('transaksi', 'Transaksi::index');
$routes->get('transaksi/create', 'Transaksi::create');
$routes->post('transaksi/store', 'Transaksi::store');
$routes->get('transaksi/edit/(:num)', 'Transaksi::edit/$1');
$routes->post('transaksi/update/(:num)', 'Transaksi::update/$1');
$routes->get('transaksi/delete/(:num)', 'Transaksi::delete/$1');

$routes->post('transaksi/data', 'Transaksi::data');

$routes->get('transaksi/send/(:any)', 'Transaksi::send_konfirmasi/$1');
$routes->get('transaksi/invoice/(:segment)', 'Transaksi::invoice/$1');

$routes->get('whatsapp','whatsapp::send');

//POTENSI START
$routes->get('potensi', 'potensi::index');

$routes->get('potensi/create', 'potensi::create');
$routes->post('potensi/store', 'potensi::store');
$routes->get('potensi/edit/(:num)', 'potensi::edit/$1');
$routes->post('potensi/update/(:num)', 'potensi::update/$1');
$routes->get('potensi/delete/(:num)', 'potensi::delete/$1');

$routes->post('potensi/data', 'potensi::data');

$routes->get('potensi/send/(:any)', 'potensi::send_konfirmasi/$1');
$routes->get('potensi/invoice/(:segment)', 'potensi::invoice/$1');