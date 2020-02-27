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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['index'] = 'LoginController/index';
$route['login'] = 'LoginController/login';
$route['login_p'] = 'LoginController/login_p';
$route['logout'] = 'LoginController/logout';

$route['mst_profile'] = 'MasterController/profile';
$route['mst_profile/(:any)/(:any)/(:any)'] = 'MasterController/profile_act/$1/$2/$3';

$route['mst_menu'] = 'MasterController/menu';
$route['mst_menu/menu_act/(:any)/(:any)'] = 'MasterController/menu_act/$1/$2';

$route['mst_dept'] = 'MasterController/mst_dept';
$route['mst_dept/dept_act/(:any)'] = 'MasterController/dept_act/$1';
$route['mst_dept/dept_act/(:any)/(:any)'] = 'MasterController/dept_act/$1/$2';

$route['mst_subdept'] = 'MasterController/mst_subdept';
$route['mst_subdept/subdept_act/(:any)'] = 'MasterController/subdept_act/$1';
$route['mst_subdept/subdept_act/(:any)/(:any)'] = 'MasterController/subdept_act/$1/$2';

$route['mst_jabt'] = 'MasterController/mst_jabt';
$route['mst_jabt/jabt_act/(:any)'] = 'MasterController/jabt_act/$1';
$route['mst_jabt/jabt_act/(:any)/(:any)'] = 'MasterController/jabt_act/$1/$2';

$route['sls_stage'] = 'SalesController/sls_stage';
$route['sls_stage/sls_stage_act/(:any)'] = 'SalesController/sls_stage_act/$1';
$route['sls_stage/sls_stage_act/(:any)/(:any)'] = 'SalesController/sls_stage_act/$1/$2';

$route['sls_oppo_type'] = 'SalesController/sls_oppo_type';
$route['sls_oppo_type/sls_oppo_type_act/(:any)'] = 'SalesController/sls_oppo_type_act/$1';
$route['sls_oppo_type/sls_oppo_type_act/(:any)/(:any)'] = 'SalesController/sls_oppo_type_act/$1/$2';