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
