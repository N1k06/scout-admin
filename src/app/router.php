<?php
require_once 'branca.php';
require_once "db.php";

    function router($method, $uri, $routes) 
    {
        $uri = urldecode($uri);
        $uri_segments = explode('/', trim($uri, '/'));

        if (isset($routes[$method])) 
        {
            foreach ($routes[$method] as $route => $handler) {
                $route_segments = explode('/', trim($route, '/'));
                $params = [];

                if (count($uri_segments) === count($route_segments)) 
                {
                    $match = true;
                    for ($i = 0; $i < count($uri_segments); $i++) 
                    {
                        if ($route_segments[$i][0] === '{' && substr($route_segments[$i], -1) === '}') 
                        {
                            $params[] = $uri_segments[$i];
                        } 
                        elseif ($uri_segments[$i] !== $route_segments[$i]) 
                        {
                            $match = false;
                            break;
                        }
                    }

                    if ($match) 
                    {
                        call_user_func_array($handler, $params);
                        return;
                    }
                }
            }
        }
    }

    //GET
    function gestisci_elenco_persone() 
    {
        require_once("db.php");
        $stmt = $conn->prepare("SELECT * FROM Persona");
        $stmt->execute();
        $result = $stmt->get_result();

        $data = array();
        while ($row = $result->fetch_assoc()) 
        {
            $data[] = $row;
        }

        $conn->close();
        echo json_encode($data);
    }
    function gestisci_persone_per_id($id) 
    {
        require_once("db.php");
        $stmt = $conn->prepare("SELECT * FROM Persona WHERE id_persona = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = array();
        while ($row = $result->fetch_assoc()) 
        {
            $data[] = $row;
        }

        $conn->close();
        echo json_encode($data);
    }

    //POST
    function inserimento_persone() 
    {
        require_once("db.php");
        $stmt = $conn->prepare("INSERT INTO Persona (nome, cognome, data_nascita, luogo_nascita, telefono, via_residenza, citta_residenza, cap_residenza, id_tutore1) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)");
        $stmt->bind_param("ssssssss", $_POST['nome'], $_POST['cognome'], $_POST['data_nascita'], $_POST['luogo_nascita'], $_POST['telefono'], $_POST['via_residenza'], $_POST['citta_residenza'], $_POST['cap_residenza']);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = array();
        while ($row = $result->fetch_assoc()) 
        {
            $data[] = $row;
        }

        $conn->close();
        echo json_encode($data);
    }

    //PUT
    function gestisci_persona($id) 
    {
        if(isset($_POST['nome']) || isset($_POST['cognome']) || isset($_POST['telefono']) || isset($_POST['via_residenza']) || isset($_POST['citta_residenza']) || isset($_POST['cap_residenza']))
        {
            require_once("db.php");
            $stmt = $conn->prepare("SELECT nome, cognome, telefono, via_residenza, città_residenza, cap_residenza FROM Persona WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            $aux = array();
            while ($row = $result->fetch_assoc()) 
            {
                $aux[] = $row;
            }

            foreach($_POST as $key => $value)
            {
                if(isset(aux[$key]))
                {
                    $aux[$key] = $_POST[$key];
                }
            }

            $stmt = $conn->prepare("UPDATE Persona SET nome = ?, cognome = ?, telefono = ?, via_residenza = ?, citta_residenza = ?, cap_residenza = ? WHERE id = ?");
            $stmt->bind_param("sssssi", aux['nome'], aux['cognome'], aux['telefono'], aux['via_residenza'], aux['citta_residenza'], aux['cap_residenza'], $id);
            $stmt->execute();
            $result = $stmt->get_result();
        }
        
    }

    function gestisci_richiesta_non_valida() 
    {
        http_response_code(404);
        echo "Risorsa non trovata";
    }

function insert_account()
{
    global $conn;

    if (isset($_POST['email']) && 
        isset($_POST['password']) && 
        isset($_POST['username']) && 
        isset($_POST['id_persona'])) 
    {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $query = "INSERT INTO Account (email, password, username, id_persona) VALUES (:email, :password, :username, :id_persona)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
        $stmt->bindParam(':id_persona', $_POST['id_persona'], PDO::PARAM_INT);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            echo json_encode("success");
            return;
        }
    }
    echo json_encode("error");
}

function read_account()
{
    global $conn;

    if (isset($_POST['username'])) 
    {
        $query = "SELECT * FROM account WHERE username = :username";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
        $stmt->execute();
    
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
        {
            echo json_encode($row);
            return;
        }
    }
    echo json_encode("error");
}

function update_account()
{
    global $conn;

    if (isset($_POST['email']) && 
        isset($_POST['password']) && 
        isset($_POST['old_username']) && 
        isset($_POST['new_username']) && 
        isset($_POST['id_persona'])) 
    {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $query = "UPDATE Account SET email = :email, password = :password, username = :new_username, id_persona = :id_persona WHERE username = :old_username";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':old_username', $_POST['old_username'], PDO::PARAM_STR);
        $stmt->bindParam(':new_username', $_POST['new_username'], PDO::PARAM_STR);
        $stmt->bindParam(':id_persona', $_POST['id_persona'], PDO::PARAM_INT);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            echo json_encode("success");
            return;
        }
    }
    echo json_encode("error");
}

function gestisci_attivita($id_attivita) 
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM attività NATURAL JOIN persona NATURAL JOIN partecipa NATURAL JOIN unita NATURAL JOIN branca WHERE id_attivita = :id");
    $stmt->bindParam(':id', $id_attivita, PDO::PARAM_INT);

    // Esegui
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if($result)
    {
        echo json_encode($result);
        return;
    }

    echo json_encode("error");
}

function gestisci_login() 
{
    if (isset($_POST['password']) && 
        isset($_POST['username'])) 
    {
        global $conn;

        $password = $_POST['password'];
        $username = $_POST['username'];

        // Prepariamo la query per inserire la persona
        $query = "select * from account natural join persona where username = :username";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        if($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            if(password_verify($password, $row['password']))
            {
                echo json_encode($row);
                return;
            }
            else
            {
                echo json_encode("error");
                return;
            }
        }
        else
        {
            echo json_encode("error");
            return;
        }
    } 
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
        isset($_POST['telefono'])) 
    {
        global $conn;

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

        // Prepariamo la query per inserire la persona
        $query = "INSERT INTO Persona (nome, cognome, data_nascita, luogo_nascita, via_residenza, citta_residenza, cap_residenza, telefono) 
                  VALUES (:nome, :cognome, :data_nascita, :luogo_nascita, :via_residenza, :citta_residenza, :cap_residenza, :telefono)";
        
        // Prepara la query
        $stmt = $conn->prepare($query);

        // Associa i parametri alla query1
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':cognome', $cognome, PDO::PARAM_STR);
        $stmt->bindParam(':data_nascita', $data_nascita, PDO::PARAM_STR);
        $stmt->bindParam(':luogo_nascita', $luogo_nascita, PDO::PARAM_STR);
        $stmt->bindParam(':via_residenza', $via_residenza, PDO::PARAM_STR);
        $stmt->bindParam(':citta_residenza', $citta_residenza, PDO::PARAM_STR);
        $stmt->bindParam(':cap_residenza', $cap_residenza, PDO::PARAM_STR);
        $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);

        // Esegui la query
        $stmt->execute();

        // Se l'inserimento nella tabella Persona ha successo, inseriamo nell'Account
        if ($stmt->rowCount() > 0) {
            $insert_id = $conn->lastInsertId();

            // Hash della password
            $hash = password_hash($password, PASSWORD_DEFAULT);

            // Prepara la query per l'inserimento dell'account
            $query = "INSERT INTO Account (email, password, username, id_persona) 
                      VALUES (:email, :password, :username, :id_persona)";

            // Prepara la query
            $stmt = $conn->prepare($query);

            // Associa i parametri alla query
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hash, PDO::PARAM_STR);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':id_persona', $insert_id, PDO::PARAM_INT);

            // Esegui la query
            $stmt->execute();

            // Verifica se l'inserimento nell'account è andato a buon fine
            if ($stmt->rowCount() > 0) {
                echo json_encode("Successo");
                return;
            }
        }

        echo json_encode("Errore nell'inserimento dei dati");
    } 
    else {
        echo json_encode("Dati mancanti");
    }
}

function update_articolo(){
    //prova parsing body della richiesta su PUT usando request_parse_body
    //richiesto php >= 8.4 
    //evita di gestire manualmente lo stream da php://input
    //vedi https://www.php.net/manual/en/function.request-parse-body.php
    [$_POST, $_FILES] = request_parse_body();
    var_dump($_POST);
    var_dump($_FILES);
}
