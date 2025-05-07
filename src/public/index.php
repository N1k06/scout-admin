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
        '/api/read_attivita/{id_attivita}' => 'read_attivita',
        '/api/insert_attivita' => 'insert_attivita'
    ],
    'POST' => [
        '/api/auth' => 'gestisci_autenticazione',
        '/api/articoli' => 'crea_articolo',
        '/api/signup' => 'gestisci_signup',
        '/api/login' => 'gestisci_login',
        '/api/insert_account' => 'insert_account'
        '/api/read_account' => 'read_account'
    ],
    'PUT' => [
        '/api/update_account' => 'update_account',
        '/api/update_attivita' => 'update_attivita'
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