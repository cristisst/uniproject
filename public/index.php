<?php
/**
 * Register the autoloader
 */

use App\Core\Http\Routing\Request;

require __DIR__.'/../vendor/autoload.php';

/**
 * booting the app
 */
$app = require_once __DIR__.'/../bootstrap/app.php';

//Capturing the request
$app->set('request', function () {
    return new Request();
});
$request = $app->get('request');

//set the response server protocol
$protocolVersion = $request->getServer('SERVER_PROTOCOL');

//status texts
$statusText = [
    200 => 'OK',
    400 => 'Bad request',
    404 => 'Not found'
];

//Get the router instance
$router = $app->get('router');
try {
    $response = $router->dispatch($request);
    $statusCode = 200;
    if (is_array($response) || $response instanceof JsonSerializable) {
        header('Content-type: application/json');
        // Encoding <, >, ', &, " characters in the json string
        // 15 === JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP |JSON_HEX_QUOT
        $response = json_encode($response, 15);
    } else {
        header("Content-type: text/html");
    }
    header(sprintf('%s %s %s', $protocolVersion, $statusCode, $statusText[$statusCode]));
    echo $response;
} catch (Exception $e) {
    $statusCode = 400;
    header(sprintf('%s %s %s', $protocolVersion, $statusCode, $statusText[$statusCode]));
    echo $e->getMessage();
}




