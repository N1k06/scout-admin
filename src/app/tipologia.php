<?php
    function insert_tipologia(){ 
        include 'db.php';

        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        if (!isset($data['nome']) || trim($data['nome']) === '') {
            http_response_code(400);
            echo json_encode(['errore' => 'Campo Nome mancante o vuoto']);
            return;
        }
        
        $nome = $data['nome'];
        $descrizione = isset($data['descrizione']) ? $data['descrizione'] : null;
    
        $stmt = $conn->prepare("SELECT nome FROM Tipologia WHERE nome = ?");
        $stmt->bind_param("s", $nome);
        $stmt->execute();
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            echo json_encode(['errore' => 'Nome già esistente']);
        } else {
            // Inserisce il nuovo valore
            $stmt_insert = $conn->prepare("INSERT INTO Tipologia (nome, descrizione) VALUES (?, ?)");
            $stmt_insert->bind_param("ss", $nome, $descrizione);
            $success = $stmt_insert->execute();

            if ($success == TRUE) {
                echo json_encode(['stato' => 'ok', 'messaggio' => 'Unità inserita con successo']);
            } else {
                echo json_encode(['errore' => 'Errore durante l inserimento dell unità']);
            }
        }
        
    }

    function read_tipologia(){
        include 'db.php';
        $sql = "SELECT * FROM Tipologia";
        $result = $conn->query($sql);
        $data = [];
        if ($result->num_rows > 0) 
        {
            while ($row = $result->fetch_assoc()) 
            {
                $data[] = $row;
            }
        }
        echo json_encode($data);
    }

    function update_tipologia($id_tipologia) {
        include 'db.php';
    
        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);
    
        if (!isset($data['nome'])) {
            http_response_code(400);
            echo json_encode(['errore' => 'Campo nome mancante']);
            return;
        }
    
        if (!isset($data['descrizione'])) {
            http_response_code(400);
            echo json_encode(['errore' => 'Campo descrizione mancante']);
            return;
        }
    
        $nome = $data['nome'];
        $descrizione = $data['descrizione'];

        
        $sql_controll = "SELECT id_tipologia FROM Tipologia WHERE id_tipologia = '$id_tipologia'";
        $result = $conn->query($sql_controll);

        if ($result->num_rows == 0) {
            http_response_code(400);
            echo json_encode(['errore' => 'Id_tipologia non esistente']);

        } else {

            $sql = 'UPDATE Tipologia SET nome = ?, descrizione = ? WHERE id_tipologia = ?';
            $stmt = $conn->prepare($sql);
    
            if ($stmt === false) {
                http_response_code(500);
                echo json_encode(['errore' => 'Errore nella preparazione della query']);
                return;
            }
    
            $stmt->bind_param('ssi', $nome, $descrizione, $id_tipologia);
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
    }
    