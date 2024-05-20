<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['logout'] = 'Login/logout';

$route['clientes/busca'] = 'Clientes/index';
$route['clientes/(:num)'] = 'Clientes/index/$1';
$route['clientes/editar/(:num)'] = 'Clientes/editar/$1';
$route['clientes/post'] = 'Clientes/post';
$route['clientes/logo/delete/(:num)'] = 'Clientes/deleteLogo/$1';

$route['contratos/(:num)'] = 'Contratos/index/$1';
$route['contratos/incluir/(:num)'] = 'Contratos/incluir/$1';
$route['contratos/incluir/(:num)/(:num)'] = 'Contratos/incluir/$1/$2';
$route['contratos/editar/(:num)'] = 'Contratos/editar/$1';
$route['contratos/post'] = 'Contratos/post';
$route['contratos/cliente/(:num)'] = 'Contratos/contratosCliente/$1';
$route['contratos/cliente/(:num)/(:num)'] = 'Contratos/contratoCliente/$1/$2';
$route['contratos/cliente/(:num)/last'] = 'Contratos/contratoClienteLast/$1';
$route['contratos/visualizar/(:num)'] = 'Contratos/view/$1';
$route['contratos/visualizar/(:num)/print'] = 'Contratos/view/$1/print';
$route['contratos/quitacao/(:num)'] = 'Contratos/release/$1';

$route['categorias/(:num)'] = 'Categorias/index/$1';
$route['categorias/editar/(:num)'] = 'Categorias/editar/$1';
$route['categorias/post'] = 'Categorias/post';

$route['cobradores/(:num)'] = 'Cobradores/index/$1';
$route['cobradores/editar/(:num)'] = 'Cobradores/editar/$1';
$route['cobradores/post'] = 'Cobradores/post';

$route['status/(:num)'] = 'Status/index/$1';
$route['status/editar/(:num)'] = 'Status/editar/$1';
$route['status/post'] = 'Status/post';

$route['api/json_clientes/(:any)'] = 'Api/json_clientes/$1';