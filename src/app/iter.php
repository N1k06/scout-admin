<?php

function read_iter()
{
    global $conn;

    if (isset($_POST['id_iter'])) 
    {
        $query = "SELECT * FROM Iter WHERE id_iter = :id_iter";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':iter', $_POST['id_iter'], PDO::PARAM_INT);
        $stmt->execute();
    
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
        {
            echo json_encode($row);
            return;
        }
    }
    echo json_encode("error");
}
?>