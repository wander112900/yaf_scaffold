<?php
define("APP_PATH",  realpath(dirname(__FILE__) . "/../"));
define("PUBLIC_PATH",  dirname(__FILE__));
define('CRLF', "\r\n");

$app  = new \Yaf\Application(APP_PATH . "/config/application.ini");
$app->bootstrap()
    ->run();
?>
