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

function gestisci_attivita($id_attivita) 
{
    require_once "db.php";

    $query = "SELECT * FROM attività NATURAL JOIN persona NATURAL JOIN partecipa NATURAL JOIN unita NATURAL JOIN branca WHERE id_attivita = $id_attivita";
    $result = mysqli_query($conn, $query);

    if($result)
    {
        $data = [];
        while($row = mysqli_fetch_assoc($result))
            $data[] = $row;
        echo json_encode($data);
        return;
    }

    echo json_encode("error");
}