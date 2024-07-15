<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE');
header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

require_once "./modules/get.php";
require_once "./modules/post.php";
require_once "./config/database.php";

$con = new Connection();
$pdo = $con->connect();

$get = new Get($pdo);
$post = new Post($pdo);

if (isset($_REQUEST['request'])) {
    $request = explode('/', $_REQUEST['request']);
} else {
    echo "Not Found";
    http_response_code(404);
    exit();
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        switch ($request[0]) {
            case 'weather':
                if (isset($request[1])) {
                    $city = $request[1];
                } else {
                    $city = $defaultCity;
                }
                $days = isset($_GET['days']) ? intval($_GET['days']) : 1;
                $response = $get->fetchWeather($city, $days);

                error_log("Fetching weather for city: $city");

                sendResponse($response);
                break;
                case 'weather-lat-lon':
                    $latitude = $request[1];
                    $longitude = $request[2];
                    $response = $get->searchWeatherByCoords($latitude, $longitude);
                  
                    error_log("Fetching weather for coordinates: $latitude, $longitude");
                  
                    sendResponse($response);
                    break;

            default:
                echo "Not Found";
                http_response_code(404);
                break;
        }
        break;
    }

function sendResponse($data, $status = 200)
{
    http_response_code($status);
    echo json_encode($data);
}
?>
