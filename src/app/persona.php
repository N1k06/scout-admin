<?php
    require_once "ausiliar_function.php";

    //GET
    function gestisci_elenco_persone() 
    {
        global $conn;

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
        global $conn;
        echo $_SERVER['REQUEST_METHOD'];

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
        global $conn;

        $POST = file_get_contents('php://input');
        $POST = json_decode($POST, true);

        //Calcolo età
        $now = new DateTime();
        $today = $now->format('Y-m-d');
        $birthday = new DateTime($POST['data_nascita']);
        $diff = $birthday->diff($now);
        $age = $diff->y;

        $id_tutore = 0;
        $aux = preg_replace('/\D/', '', $POST['id_tutore1']); //Mi assicuro che l'id siano solo numeri

        if($aux == "" && $age >= 18) //Se non esiste l'id tuttore e l'età è maggiore di 18 allora va bene
        {
            $id_tutore = null;
        }
        elseif($aux == "" && $age < 18) //Se non esiste l'id tutore ed è minorenne da errore
        {
            gestisci_richiesta_non_valida();
        }
        elseif($aux != "" && verifica_esistenza_id_persona($aux)) //Se esite ed è di una persona esistente allora continuo
        {
            $id_tutore = $aux;
        }
        else if(!verifica_esistenza_id_persona($aux))
        {
            gestisci_richiesta_non_valida();
        }
        
        controllo_integrita_perosna($POST);

        $stmt = $conn->prepare("INSERT INTO Persona (nome, cognome, data_nascita, luogo_nascita, telefono, via_residenza, citta_residenza, cap_residenza, id_tutore1) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssi", $POST['nome'], $POST['cognome'], $POST['data_nascita'], $POST['luogo_nascita'], $POST['telefono'], $POST['via_residenza'], $POST['citta_residenza'], $POST['cap_residenza'], $id_tutore);
        $stmt->execute();  
    }

    function controllo_integrita_perosna($Persona)
    {
        $Persona['telefono'] = preg_replace('/\D/', '', $Persona['telefono']);
        if(!is_valid_phone($POST['telefono']))
        {
            gestisci_richiesta_non_valida() 
        }

        $Persona['cap_residenza'] = preg_replace('/\D/', '', $Persona['cap_residenza']);
        if(!is_valid_cap($POST['cap_residenza']))
        {
            gestisci_richiesta_non_valida() 
        }

        if(!is_valid_date($POST['data_nascita']))
        {
            gestisci_richiesta_non_valida() 
        }
    }

    //PUT
    function aggiorna_persona($id) 
    {
        global $conn;
        $PUT = file_get_contents('php://input');
        $input = json_decode($PUT, true);

        if(isset($input['nome']) || isset($input['cognome']) || isset($input['telefono']) || isset($input['via_residenza']) || isset($input['citta_residenza']) || isset($input['cap_residenza']))
        {
            $stmt = $conn->prepare("SELECT nome, cognome, telefono, via_residenza, citta_residenza, cap_residenza FROM Persona WHERE id_persona = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            $aux = array();
            while ($row = $result->fetch_assoc()) 
            {
                $aux = $row;
            }

            foreach($input as $key => $value)
            {
                if(isset($aux[$key]))
                {
                    $aux[$key] = $input[$key];
                }
            }

            $stmt = $conn->prepare("UPDATE Persona SET nome = ?, cognome = ?, telefono = ?, via_residenza = ?, citta_residenza = ?, cap_residenza = ? WHERE id_persona = ?");
            $stmt->bind_param("ssssssi", $aux['nome'], $aux['cognome'], $aux['telefono'], $aux['via_residenza'], $aux['citta_residenza'], $aux['cap_residenza'], $id);
            $stmt->execute();
        }
    }


    function verifica_esistenza_id_persona($id)
    {
        global $conn;

        $stmt = $conn->prepare("SELECT id_persona FROM Persona WHERE id_persona = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0);
    }