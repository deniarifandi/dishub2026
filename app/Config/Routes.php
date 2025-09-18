<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//HOME
$routes->get('/', 'Home::index');
$routes->get('/commandcenter','Home::commandcenter');

//HOME DATA
$routes->get('/pendapatanhariini','Home::getPendapatanHariIni');

//Syn
$routes->get('/syncdata','Home::syncdata');

//VA OWNER
$routes->get('va-owner', 'VaOwnerController::index');
$routes->get('va-owner/create', 'VaOwnerController::create');
$routes->post('va-owner/store', 'VaOwnerController::store');
$routes->get('va-owner/edit/(:num)', 'VaOwnerController::edit/$1');
$routes->post('va-owner/update/(:num)', 'VaOwnerController::update/$1');
$routes->get('va-owner/delete/(:num)', 'VaOwnerController::delete/$1');
$routes->post('va-owner/data', 'VaOwnerController::data');

$routes->get('va-owner/getaccesstoken','VaOwnerController::getaccesstoken');

//transaksi START
$routes->get('transaksi', 'Transaksi::index');
$routes->get('transaksi/create', 'Transaksi::create');
$routes->post('transaksi/store', 'Transaksi::store');
$routes->get('transaksi/edit/(:num)', 'Transaksi::edit/$1');
$routes->post('transaksi/update/(:num)', 'Transaksi::update/$1');
$routes->get('transaksi/delete/(:num)', 'Transaksi::delete/$1');

$routes->post('transaksi/data', 'Transaksi::data');
$routes->get('transaksi/gettransaksibulanan/(:num)/(:num)','Transaksi::getTransaksiBulanan/$1/$2');

$routes->get('transaksi/send/(:any)', 'Transaksi::send_konfirmasi/$1');
$routes->get('transaksi/invoice/(:segment)', 'Transaksi::invoice/$1');

$routes->get('whatsapp','whatsapp::send');



//POTENSI START
$routes->get('potensi', 'Potensi::index');

$routes->get('potensi/create/(:num)', 'Potensi::create/$1');
$routes->post('potensi/store/(:num)', 'Potensi::store/$1');
$routes->get('potensi/edit/(:num)', 'Potensi::edit/$1');
$routes->post('potensi/update/(:num)', 'Potensi::update/$1');
$routes->get('potensi/delete/(:num)', 'Potensi::delete/$1');

$routes->post('potensi/data', 'Potensi::data');

$routes->get('potensi/send/(:any)', 'Potensi::send_konfirmasi/$1');
$routes->get('potensi/invoice/(:segment)', 'Potensi::invoice/$1');

//Tagihan Start
$routes->get('potensi/realisasi', 'Potensi::realisasi');
$routes->post('potensi/datatagihan', 'Potensi::datatagihan');

//API Jatim
$routes->get('api/jatim/getaccesstoken','Jatim::get_access_token');
$routes->get('api/jatim/signatureaccesstoken','Jatim::signature_access_token');
$routes->get('api/jatim/getsignature','Jatim::getSignature');

$routes->get('api/jatim/inquiry-va','Jatim::inquiryva');
$routes->get('api/jatim/create-va','Jatim::createva');

//API Sisparma
$routes->post('api/v1.0/transfer-va/va-notify','Sisparma::va_notify');