<?php
require __DIR__ . '/vendor/autoload.php';

$dateFormat = "Y-m-d H:i:s";
$outputFormat = "%datetime% %level_name% %message% %context% %extra%  (%channel%)\n";
$formatter = new Monolog\Formatter\LineFormatter($outputFormat, $dateFormat);
$logHandler = new Monolog\Handler\RotatingFileHandler(__DIR__ . '\logs\notif.log', Monolog\Logger::DEBUG);
$logHandler->setFormatter($formatter);

$log = new Monolog\Logger('G');
$log->pushHandler($logHandler);

$requestBodyStr = file_get_contents('php://input');
$log->addInfo("Received:", array("get" => $_GET, "post" => $_POST, "postBody" => $requestBodyStr));

phpinfo();