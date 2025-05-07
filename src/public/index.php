<?php
require_once '../app/router.php';
require '../app/unita.php';
//phpinfo();

$routes = [
    'GET' => [
        '/api/articoli' => 'gestisci_elenco_articoli',
        '/api/articoli/{categoria}' => 'gestisci_articoli_per_categoria',
        '/api/articoli/{categoria}/{sottocategoria}' => 'gestisci_articoli_per_sottocategoria',
        '/api/articoli/{categoria}/{sottocategoria}/{slug}' => 'gestisci_articolo',
    ],
    'POST' => [
        '/api/auth' => 'gestisci_autenticazione',
        '/api/articoli' => 'crea_articolo',
        '/api/signup' => 'gestisci_signup',
        '/api/login' => 'gestisci_login',
    ],
    'PUT' => [
    ],
    'DELETE' => [
        '/api/articoli/{categoria}/{sottocategoria}/{slug}' => 'elimina_articolo'
    ]
];

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

//echo "Metodo: " . $method . "<br>";
//echo "URI: " . $uri . "<br>";

router($method, $uri, $routes);
?>