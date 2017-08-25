<?php
require __DIR__ . '/vendor/autoload.php';

function getUserIP() {
	$ip = '';
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	elseif (!empty($_SERVER['REMOTE_ADDR'])) {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	else {
		$ip = '';
	}
	return $ip;
}

$dateFormat = "Y-m-d H:i:s";
$outputFormat = "%datetime% %level_name% %message% %context% %extra%  (%channel%)\n";
$formatter = new Monolog\Formatter\LineFormatter($outputFormat, $dateFormat);
$logHandler = new Monolog\Handler\RotatingFileHandler(__DIR__ . '\logs\notif.log', Monolog\Logger::DEBUG);
$logHandler->setFormatter($formatter);

$log = new Monolog\Logger('G');
$log->pushHandler($logHandler);

$requestBodyStr = file_get_contents('php://input');
$info = array(
	"REMOTE_ADDR" => @$_SERVER['REMOTE_ADDR'], 
	"HTTP_CLIENT_IP" => @$_SERVER['HTTP_CLIENT_IP'], 
	"HTTP_X_FORWARDED_FOR" => @$_SERVER['HTTP_X_FORWARDED_FOR'], 
	"IP" => getUserIP(), 
	"HEADERS" => getallheaders(),
	"REQUEST" => $_REQUEST,
	"AUTH_USER" => @$_SERVER['PHP_AUTH_USER'], 
	"AUTH_PW" => @$_SERVER['PHP_AUTH_PW'], 
	"GET" => $_GET, 
	"POST" => $_POST, 
	"PostBody" => $requestBodyStr);
$log->addInfo("Received:", $info);

echo "<pre>";
print_r($info);
echo "</pre>";
//phpinfo();
