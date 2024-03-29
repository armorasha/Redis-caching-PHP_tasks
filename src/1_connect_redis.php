<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/../vendor/predis/predis/autoload.php";
// require "predis/autoloader.php";

use Predis\Autoloader;
use Predis\Client;

// PredisAutoloader::register();
Autoloader::register();

// since we connect to default setting localhost
// and 6379 port there is no need for extra
// configuration. If not then you can specify the
// scheme, host and port to connect as an array
// to the constructor.
try {
    $redis = new Client();
    /*
    $redis = new PredisClient(array(
        "scheme" => "tcp",
        "host" => "127.0.0.1",
        "port" => 6379));
*/
    echo "Successfully connected to Redis";
} catch (Exception $e) {
    echo "Couldn't connected to Redis";
    echo $e->getMessage();
}
