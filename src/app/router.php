<?php

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
?>



