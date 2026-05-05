<?php

session_start();

// Load autoloader dari composer
require_once __DIR__ . '/../vendor/autoload.php';

use Core\Router;

// Inisialisasi router
$router = new Router();

// --- RUTE AUTENTIKASI ---
$router->add('GET',  '/login',  'App\Controllers\AuthController@showLogin');
$router->add('POST', '/login',  'App\Controllers\AuthController@login');
$router->add('GET',  '/logout', 'App\Controllers\AuthController@logout');

// --- RUTE DASHBOARD ---
$router->add('GET', '/', 'App\Controllers\HomeController@index');

// --- RUTE COA (Chart of Accounts) ---
$router->add('GET',  '/accounts',            'App\Controllers\AccountController@index');
$router->add('GET',  '/accounts/create',     'App\Controllers\AccountController@create');
$router->add('POST', '/accounts/store',      'App\Controllers\AccountController@store');
$router->add('GET',  '/accounts/edit/{id}',  'App\Controllers\AccountController@edit');
$router->add('POST', '/accounts/update/{id}', 'App\Controllers\AccountController@update');

// --- RUTE JURNAL ---
$router->add('GET',  '/journals',        'App\Controllers\JournalController@index');
$router->add('GET',  '/journals/create', 'App\Controllers\JournalController@create');
$router->add('POST', '/journals/store',  'App\Controllers\JournalController@store');
$router->add('GET',  '/journals/view/{id}', 'App\Controllers\JournalController@show');

// --- RUTE LAPORAN ---
$router->add('GET', '/reports/balance-sheet', 'App\Controllers\ReportController@balanceSheet');

// --- RUTE MANAJEMEN USER (Admin Only) ---
$router->add('GET',  '/users',              'App\Controllers\UserController@index');
$router->add('GET',  '/users/create',       'App\Controllers\UserController@create');
$router->add('POST', '/users/store',        'App\Controllers\UserController@store');
$router->add('GET',  '/users/edit/{id}',    'App\Controllers\UserController@edit');
$router->add('POST', '/users/update/{id}',  'App\Controllers\UserController@update');
$router->add('GET',  '/users/delete/{id}',  'App\Controllers\UserController@delete');

// Jalankan routing berdasarkan URL
$router->dispatch($_SERVER['REQUEST_URI']);
