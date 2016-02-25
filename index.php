<?php
require __DIR__ . '/vendor/autoload.php';

function getUserIP() {
	$client = @$_SERVER['HTTP_CLIENT_IP'];
	$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	$remote = $_SERVER['REMOTE_ADDR'];

	if (filter_var($client, FILTER_VALIDATE_IP)) {
		$ip = $client;
	} elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
		$ip = $forward;
	} else {
		$ip = $remote;
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
$info = array("REMOTE_ADDR" => $_SERVER['REMOTE_ADDR'], "IP" => getUserIP(), "get" => $_GET, "post" => $_POST, "postBody" => $requestBodyStr);
$log->addInfo("Received:", $info);

echo "<pre>";
var_dump($info);
echo "</pre>";
//phpinfo();
