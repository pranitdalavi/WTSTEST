<?php

session_start();

require __DIR__. '/../vendor/autoload.php';

define('HOST', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DATABASE', 'comfortbedsdatabase');
define('DOMAIN', 'http://localhost/comfortbeds');
define('COMPANY_NAME', 'Comfortbeds');

define('SMTP_HOST', 'smtp.livemail.co.uk');
define('SMTP_USERNAME', 'david@wts-group.com');
define('SMTP_EMAIL', 'david@wts-group.com');
define('SMTP_PASSWORD', 'emailpassword');

define('SALT', 'fggrt5454tgU6VYhM14ZNrrFdpoDyWxflTe0kcL5m3XsKt54y65hgFGFSGDSGFDS');
define('SESSION', 'NWZdfRut39VyQrPIFKoa6XCg0fgfgr5454hgtgrghhx4lJDvbFDFE4tryhf');

date_default_timezone_set('Europe/London');
define('DT', date('Y-m-d H:i:s'));
define('FILE', basename($_SERVER['SCRIPT_NAME']));


$user = new App\User;
$cartObj = new App\Cart;
$categoryObj = new App\Category;
$subCategoryObj = new App\SubCategory;


if( !$user->uniqueId() ){

	$user->setUniqueId();

}


App\Helpers\Tools::boot();

function redirect($url, $message = null, $type = null){

	if($message){

		$message = $type == 'e' ? App\Helpers\Tools::error($message)  App\Helpers\Tools::flash($message);

	}

header('Location: '.$url); exit;

}




$url = $_SERVER['REQUEST_URI'];
$slug = explode('/', $_SERVER['REQUEST_URI']);
$slug = $slug[count($slug)-1];





