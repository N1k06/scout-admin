<?php

function read_servizio()
{
    global $conn;

    if (isset($_POST["anno_associativo"]) && 
    isset($_POST["id_persona"]) && 
    isset($_POST["id_tipologia"]) && 
    isset($_POST["id_unita"]))
    {
        $stmt->prepare("SELECT * FROM Servizio WHERE anno_associativo = :anno_associativo AND id_persona = :id_persona");
        $stmt->bindParam(":anno_associativo", $_POST["anno_associativo"], PDO::PARAM_INT);
        $stmt->bindParam(":id_persona", $_POST["id_persona"], PDO::PARAM_INT);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            echo json_encode($row);
            return;
        }
    }
    echo json_encode("error");
}

function insert_servizio()
{
    global $conn;

    if (isset($_POST["anno_associativo"]) && 
    isset($_POST["id_persona"]) && 
    isset($_POST["id_tipologia"]) && 
    isset($_POST["id_unita"]))
    {
        $stmt->prepare("INSERT INTO Servizio (anno_associativo, id_persona, id_tipologia, id_unita) VALUE (:anno_associativo, :id_persona, :id_tipologia, :id_unita)");
        $stmt->bind_param(":anno_associativo", $_POST["anno_associativo"], PDO::PARAM_INT);
        $stmt->bind_param(":id_persona", $_POST["id_persona"], PDO::PARAM_INT);
        $stmt->bind_param(":id_tipologia", $_POST["id_tipologia"], PDO::PARAM_INT);
        $stmt->bind_param(":id_unita", $_POST["id_unita"], PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0)
        {
            echo json_encode("Successo");
            return;
        }
    }
    echo json_encode("error");
}

function update_servizio()
{
    global $conn;

    [$_POST, $_FILES] = request_parse_body();

    if (isset($_POST['new_anno_associativo']) && 
        isset($_POST['new_id_persona']) && 
        isset($_POST['old_anno_associativo']) && 
        isset($_POST['old_id_persona']) && 
        isset($_POST['id_tipologia']) && 
        isset($_POST['id_unita'])) 
    {
        $stmt = $conn->prepare("UPDATE Servizio SET anno_associativo = :new_anno_associativo, id_persona = :new_id_persona, id_tipologia = :id_tipologia, id_unita = :id_unita WHERE anno_associativo = :old_anno_associativo AND id_persona = :old_id_persona");
        $stmt->bindParam(':new_anno_associativo', $_POST['new_anno_associativo'], PDO::PARAM_INT);
        $stmt->bindParam(':new_id_persona', $_POST['new_id_persona'], PDO::PARAM_INT);
        $stmt->bindParam(':old_anno_associativo', $_POST['old_anno_associativo'], PDO::PARAM_INT);
        $stmt->bindParam(':old_id_persona', $_POST['old_id_persona'], PDO::PARAM_INT);
        $stmt->bindParam(':id_tipologia', $_POST['id_tipologia'], PDO::PARAM_INT);
        $stmt->bindParam(':id_unita', $password, PDO::PARAM_INT);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) 
        {
            echo json_encode("success");
            return;
        }
    }
    echo json_encode("error");
}