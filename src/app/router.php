<?php

function router($method, $uri, $routes) {
    $uri = urldecode($uri);
    $uri_segments = explode('/', trim($uri, '/'));

    if (isset($routes[$method])) {
        foreach ($routes[$method] as $route => $handler) {
            $route_segments = explode('/', trim($route, '/'));
            $params = [];

            if (count($uri_segments) === count($route_segments)) {
                $match = true;
                for ($i = 0; $i < count($uri_segments); $i++) {
                    if ($route_segments[$i][0] === '{' && substr($route_segments[$i], -1) === '}') {
                        $params[] = $uri_segments[$i];
                    } elseif ($uri_segments[$i] !== $route_segments[$i]) {
                        $match = false;
                        break;
                    }
                }

                if ($match) {
                    call_user_func_array($handler, $params);
                    return;
                }
            }
        }
    }

    gestisci_richiesta_non_valida();
}


function insert_unita($nome_unita){
    include 'db.php';
    $sql= "INSERT INTO Unita (nome_unita) VALUES('$nome_unita')";
    $result = $conn->query($sql);
}


function gestisci_elenco_articoli() {
    echo "Elenco degli articoli";
}

function gestisci_articoli_per_categoria($categoria) {
    echo "Articoli nella categoria: " . $categoria;
}

function gestisci_articoli_per_sottocategoria($categoria, $sottocategoria) {
    echo "Articoli in " . $categoria . "/" . $sottocategoria;
}

function gestisci_articolo($categoria, $sottocategoria, $slug) {
    echo "Articolo: " . $categoria . "/" . $sottocategoria . "/" . $slug;
}

function crea_articolo() {
    echo "Creazione di un nuovo articolo";
}

function gestisci_richiesta_non_valida() {
    http_response_code(404);
    echo "Risorsa non trovata";
}

function gestisci_autenticazione() {
    echo "Autenticazione";
}

function read_unita(){
    
}

function update_unita($id_unita) {
    require_once 'db.php';

    if (!isset($_POST['Nome'])) {
        http_response_code(400);
        echo json_encode(['errore' => 'Campo Nome mancante']);
        return;
    }

    $nome = $_POST['Nome'];
    $sql = 'UPDATE Unita SET Nome = ? WHERE id = ?';
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        http_response_code(500);
        echo json_encode(['errore' => 'Errore nella preparazione della query']);
        return;
    }

    $stmt->bind_param('si', $nome, $id_unita);
    $successo = $stmt->execute();

    if ($successo) {
        echo json_encode(['stato' => 'ok', 'messaggio' => 'Unità aggiornata']);
    } else {
        http_response_code(500);
        echo json_encode(['errore' => 'Aggiornamento fallito']);
    }

    $stmt->close();
    $conn->close();
}
