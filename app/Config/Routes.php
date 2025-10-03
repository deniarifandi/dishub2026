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
$routes->get('/targetsetoranbulanan','Home::targetSetoranBulanan');

$routes->get('/getpotensicek','Home::getPotensiCek');

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

//Tiket
$routes->get('tiket', 'Tiket::index');
$routes->post('tiket/data','Tiket::data');
$routes->get('tiket/pesan/(:any)','Tiket::pesan/$1');
$routes->post('tiket/store','Tiket::store');

$routes->get('tiket/histori','Tiket::histori');
$routes->post('tiket/datahistori','Tiket::datahistori');

$routes->get('tiket/print/(:any)','Tiket::print/$1');


//Anggota
$routes->get('anggota','Anggota::index');
$routes->post('anggota/data','Anggota::data');
$routes->get('anggota/create','Anggota::create');
$routes->post('anggota/store','Anggota::store');
$routes->get('anggota/edit/(:num)', 'Anggota::edit/$1');
$routes->post('anggota/update/(:num)', 'Anggota::update/$1');
$routes->get('anggota/delete/(:num)', 'Anggota::delete/$1');

//Titpar
$routes->get('titpar','Titpar::index');
$routes->post('titpar/data','Titpar::data');
$routes->get('titpar/create','Titpar::create');
$routes->post('titpar/store','Titpar::store');
$routes->get('titpar/edit/(:num)', 'Titpar::edit/$1');
$routes->post('titpar/update/(:num)', 'Titpar::update/$1');
$routes->get('titpar/delete/(:num)', 'Titpar::delete/$1');

//Titpargrup
$routes->get('titpargrup','Titpargrup::index');
$routes->post('titpargrup/data','Titpargrup::data');
$routes->get('titpargrup/create','Titpargrup::create');
$routes->post('titpargrup/store','Titpargrup::store');
$routes->get('titpargrup/edit/(:num)', 'Titpargrup::edit/$1');
$routes->post('titpargrup/update/(:num)', 'Titpargrup::update/$1');
$routes->get('titpargrup/delete/(:num)', 'Titpargrup::delete/$1');

//API Jatim
$routes->get('api/jatim/getaccesstoken','JatimController::get_access_token');
$routes->get('api/jatim/signatureaccesstoken','JatimController::signature_access_token');
$routes->get('api/jatim/getsignature','Jatim::getSignature');

$routes->get('api/jatim/inquiry-va','Jatim::inquiryva');
$routes->get('api/jatim/create-va','Jatim::createva');

//API Sisparma
$routes->post('api/v1.0/transfer-va/va-notify','Sisparma::va_notify');