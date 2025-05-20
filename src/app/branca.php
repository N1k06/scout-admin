<?php
function leggi_branche() { 
    include 'db.php';
    $sql = "SELECT * FROM Branca";
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