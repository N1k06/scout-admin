<?php


    function insert_unita(){ 
        include 'db.php';

        
        if (!isset($_POST['nome_unita'])) {
            http_response_code(400);
            echo json_encode(['errore' => 'Campo Nome mancante']);
            return;
        }
        $nome_unita = $_POST['nome_unita']; 
        

        // Controlla se il nome esiste già
        $sql = "SELECT nome_unita FROM Unita WHERE nome_unita = '$nome_unita'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo json_encode(['errore' => 'Nome già esistente']);
        } else {
            // Inserisce il nuovo valore
            $sql_insert = "INSERT INTO Unita (nome_unita, id_branca) VALUES('$nome_unita', 1)";
            if ($conn->query($sql_insert) === TRUE) {
                echo json_encode(['stato' => 'ok', 'messaggio' => 'Unità inserita con successo']);
            } else {
                echo json_encode(['errore' => 'Errore durante l inserimento dell unità']);
            }
        }
        
    }

    function read_unita(){
        include 'db.php';
        $sql = "SELECT * FROM Unita";
        $result = $connection->query($sql);
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

    function update_unita($id_unita) {
        

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