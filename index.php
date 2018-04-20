<?php
require __DIR__ . '/vendor/autoload.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS, HEAD, DELETE, PATCH, CONNECT');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
header('Content-Type: application/json');

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

$formatter = new Monolog\Formatter\LineFormatter("%datetime% %level_name% %message% %context% %extra%  (%channel%)\n", "Y-m-d H:i:s");
$logHandler = new Monolog\Handler\RotatingFileHandler(__DIR__ . '\logs\notif.log', Monolog\Logger::DEBUG);
$logHandler->setFormatter($formatter);

$formatterNoDate = new Monolog\Formatter\LineFormatter("%level_name% %message% %context% %extra%  (%channel%)\n", "Y-m-d H:i:s");
$streamHandler = new Monolog\Handler\StreamHandler('php://stdout', Monolog\Logger::DEBUG);
$streamHandler->setFormatter($formatterNoDate);

$log = new Monolog\Logger('G');
$log->pushHandler($logHandler);
$log->pushHandler($streamHandler);

$info = array(
	"SERVER" => @$_SERVER,
	"IP" => getUserIP(), 
	"HEADERS" => getallheaders(),
	"REQUEST" => $_REQUEST,
	"GET" => $_GET, 
	"POST" => $_POST, 
	"PostBody" => file_get_contents('php://input'));
$log->addInfo("Received:", $info);

echo json_encode($info);
//phpinfo();
