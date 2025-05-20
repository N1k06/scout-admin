<?php
require_once '../app/router.php';
require '../app/unita.php';

$routes = [
    'GET' => [
        '/api/articoli' => 'gestisci_elenco_articoli',
        '/api/articoli/{categoria}' => 'gestisci_articoli_per_categoria',
        '/api/articoli/{categoria}/{sottocategoria}' => 'gestisci_articoli_per_sottocategoria',
        '/api/articoli/{categoria}/{sottocategoria}/{slug}' => 'gestisci_articolo',
        '/api/branche' => 'leggi_branche', // ritorna tutte le brance
        '/api/unita' => 'read_unita'
    ],
    'POST' => [
        '/api/auth' => 'gestisci_autenticazione',
        '/api/articoli' => 'crea_articolo',
        '/api/utenti' => 'crea_utente', //crea un utente con dati passati tramite post'
        //'/api/branche' => 'crea_branche', //crea una nuova branch con dati passati tramite post'
    ],
    'PUT' => [
        '/api/utenti/{id}' => 'modifica_utente', //modifica un utente con dati passati tramite put tutto tranne id
        '/api/branche/{id}' => 'modifica_branche', //modifica una branch con dati passati tramite put tutto tranne id
        '/api/unita' => 'insert_unita'
        '/api/signup' => 'gestisci_signup'
        '/api/login' => 'gestisci_login'
    ],
    'PUT' => [
        '/api/articoli/{categoria}/{sottocategoria}/{slug}' => 'modifica_articolo',
        '/api/unita/{id_unita}' => 'update_unita',
        '/api/articoli' => 'update_articolo'
    ]
];

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

//echo "Metodo: " . $method . "<br>";
//echo "URI: " . $uri . "<br>";

router($method, $uri, $routes);
?>