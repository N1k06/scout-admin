<?php
require_once '../app/router.php';

$routes = 
[
    'GET' => 
    [
        '/api/persone' => 'gestisci_elenco_persone',
        '/api/persone/{id}' => 'gestisci_persone_per_id',
    ],
    'POST' => 
    [
        '/api/persone' => 'inserimento_persone',
    ],
    'PUT' => 
    [
        '/api/persone/{id}' => 'gestisci_persona',
    ],
];

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

echo "Metodo: " . $method . "<br>";
echo "URI: " . $uri . "<br>";

router($method, $uri, $routes);
?>