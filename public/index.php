<?php

include_once '../api.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set("error_log", "php-error.log");


/**
 * Basic index.php router that checks the incoming REQUEST_URI and decides what response to send.
 *
 * Simple API response functions used here are located in api.php.
 *
 * Most of your snake implementation will need to happen in the "/move" command.
 */

// Get the requested URI without any query parameters on the end
$requestUri = strtok($_SERVER['REQUEST_URI'], '?');
error_log("Request: {$requestUri}");
$requestUri = str_ireplace("/PhpTekBattleSnake/public", "", $requestUri); // public server
$requestUri = str_ireplace("/public","", $requestUri); // local server

error_log(file_get_contents('php://input'));
error_log(var_export($_POST, true));

if ($requestUri == '/' || $requestUri == "")
{   //Index Section
    $apiversion = "1";
    $author     = "S";           // TODO: Your Battlesnake Username
    $color      = "#FF0000";    // TODO: Personalize
    $head       = "default";    // TODO: Personalize
    $tail       = "default";    // TODO: Personalize

    indexResponse($apiversion,$author,$color,$head, $tail);
}
elseif ($requestUri == '/start')
{
    // read the incoming request body stream and decode the JSON
    $data = json_decode(file_get_contents('php://input'));

    error_log('Start');

    // TODO - if you have a stateful snake, you could do initialization work here
    startResponse();
}
elseif ($requestUri == '/move')
{   //Move Section
    // read the incoming request body stream and decode the JSON
    $data = json_decode(file_get_contents('php://input'));

    error_log('Received move data: '.print_r($data, true));

    // TODO - Implement your Battlesnake here!
    $possibleMove = ['up', 'down', 'left', 'right'];
    moveResponse($possibleMove[array_rand($possibleMove)]);
}
elseif ($requestUri == '/end')
{
    // read the incoming request body stream and decode the JSON
    $data = json_decode(file_get_contents('php://input'));

    // TODO - if you have a stateful snake, you could do finalize work here
    endResponse();
}
else
{
    echo "Unknown request {$requestUri}";
    exit;
}