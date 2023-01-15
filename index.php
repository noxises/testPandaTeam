<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', true);
include 'autoload.php';
include 'config.php';
define('ROOT_FOLDER', realpath(__DIR__ . '/'));
session_start();
if (!isset($_SESSION['loggedIn'])) {
    $_SESSION['loggedIn'] = false;
}

$router = new Router();

$pools = (new Pool())->all();
$users = (new User())->all();
foreach ($pools as $pool) {
    $router->get('/pools/edit/' . $pool['id'], 'Pools::edit');
    $router->get('/pools/' . $pool['id'], 'Pools::show');
}



foreach($users as $user){
    
$router->post('/api/'.$user['salt'].'/all', 'Api::index');
$router->post('/api/'.$user['salt'], 'Api::GetRandomPool');
$pools = (new Pool())->GetAllPools($user['id']);
foreach($pools as $pool){
    $router->post('/api/'.$user['salt']. '/'. $pool['id'], 'Api::index');
}


}




$router->post('/pools/answers/delete', 'Pools::deleteAnswers');
$router->post('/apiinfo', 'Users::apiinfo');
$router->post('/', 'Users::account');
$router->post('/pool/add', 'Pools::create');
$router->post('/pools/save', 'Pools::save');
$router->post('/pools/delete', 'Pools::delete');
$router->get('/login', 'Users::index');
$router->get('/registration', 'Users::registration');
$router->post('/registration/create', 'Users::create');
$router->post('/login/authorization', 'Users::login');
$router->get('/logout', 'Users::logout');
$router->post('/account', 'Users::account');


$router->check();