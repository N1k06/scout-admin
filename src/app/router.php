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
        $stmt = $conn->prepare("SELECT * FROM Persone");
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
        $stmt = $conn->prepare("SELECT * FROM Persone WHERE id = ?");
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
    function inserimento_persona() 
    {
        require_once("db.php");
        $stmt = $conn->prepare("INSERT INTO Persone (nome, cognome, data_nascita, luogo_nascita, telefono, via_residenza, citta_residenza, cap_residenza) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsissi", $_POST['nome'], $_POST['cognome'], $_POST['data_nascita'], $_POST['luogo_nascita'], $_POST['telefono'], $_POST['via_residenza'], $_POST['citta_residenza'], $_POST['cap_residenza']);
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
        echo "Creazione di un nuovo articolo";
    }

    function gestisci_richiesta_non_valida() 
    {
        http_response_code(404);
        echo "Risorsa non trovata";
    }