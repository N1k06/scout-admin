<?php
function insert_unita($nome_unita){
    include 'db.php';
    $sql= "INSERT INTO Unita (nome_unita) VALUES('$nome_unita')";
    $result = $conn->query($sql);
}

function read_unita(){
    require_once 'db.php';
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