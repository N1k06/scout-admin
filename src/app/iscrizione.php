<?php

function read_iscrizione()
{
    global $conn;
    
    if (isset($_POST["id_persona"]) && isset($_POST["anno_associativo"]))
    {
        $stmt->prepare("SELECT * FROM Iscrizione WHERE anno_associativo = :anno_associativo AND id_persona = :id_persona");
        $stmt->bindParam(":anno_associativo", $_POST["anno_associativo"], PDO::PARAM_INT);  
        $stmt->bindParam(":id_persona", $_POST["id_persona"], PDO::PARAM_INT);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            echo json_encode($row);
            return;
        }
    }
    echo json_encode(error);
}

function insert_iscrizione()
{
    global $conn;
    
    if (isset($_POST["id_persona"]) && 
    isset($_POST["id_pagamento"]) && 
    isset($_POST["id_unita"]) && 
    isset($_POST["id_iter"]) &&
    isset($_POST["approvazione_capo"]) &&
    isset($_POST["anno_associativo"]))
    {
        $stmt->prepare("INSERT INTO Iscrizione (anno_associativo, id_persona, id_pagamento, id_unita, id_iter, approvazione_capo) VALUES (:anno_associativo, :id_persona, :id_pagamento, :id_unita, :id_iter,");
        $stmt->bindParam(":anno_associativo", $_POST["anno_associativo"], PDO::PARAM_INT);
        $stmt->bindParam(":id_persona", $_POST["id_persona"], PDO::PARAM_INT);
        $stmt->bindParam(":id_pagamento", $_POST["id_pagamento"], PDO::PARAM_INT);
        $stmt->bindParam(":id_unita", $_POST["id_unita"], PDO::PARAM_INT);
        $stmt->bindParam(":id_iter", $_POST["id_iter"], PDO::PARAM_INT);
        $stmt->bindParam(":approvazione_capo", $_POST["approvazione_capo"], PDO::PARAM_INT);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            echo json_encode($row);
            return;
        }
    }
    echo json_encode(error);
}
?>