<?php
require_once "db.php";

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

function gestisci_login() 
{ 
    
}

function gestisci_signup() 
{
    if (isset($_POST['nome']) && 
        isset($_POST['cognome']) && 
        isset($_POST['email']) && 
        isset($_POST['password']) && 
        isset($_POST['username']) && 
        isset($_POST['data_nascita']) && 
        isset($_POST['luogo_nascita']) &&
        isset($_POST['via_residenza']) &&
        isset($_POST['citta_residenza']) &&
        isset($_POST['cap_residenza']) &&
        iseet($_POST['telefono']))
        
    {
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $username = $_POST['username'];
        $data_nascita = $_POST['data_nascita'];
        $luogo_nascita = $_POST['luogo_nascita'];
        $via_residenza = $_POST['via_residenza'];
        $citta_residenza = $_POST['citta_residenza'];
        $cap_residenza = $_POST['cap_residenza'];
        $telefono = $_POST['telefono'];

        $query = "insert into Persona (nome, cognome, data_nascita, luogo_nascita, via_residenza, citta_residenza, cap_residenza, telefono) value ('$nome', '$cognome', '$data_nascita', '$luogo_nascita', '$via_residenza', '$citta_residenza', '$cap_residenza', '$telefono')";
        $result = $conn->query($query);

        if($result)
        {
            $insert_id = $conn->insert_id;

            $hash = password_hash($password, PASSWORD_DEFAULT);
            $query = "insert into Account (email, password, username, id_persona) value ('$email', '$hash', '$username', '$insert_id')";
            $result = $conn->query($query);
        }
    }
}