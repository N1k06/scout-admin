<?php

function read_partecipa_unita()
{
    global $conn;

    if (isset($_POST['id_unita']))
    {
        $stmt = $conn->prepare("SELECT * FROM Partecipa WHERE id_unita = :id_unita");
        $stmt->bind_param('id_unita', $_POST['id_unita'], PDO::PARAM_INT);
        $stmt_>execute();

        if ($row = stmt->fetch(PDO::FETCH_ASSOC))
        {
            echo json_encode($row);
            return;
        }
    }
    echo json_encode("error");
}

function read_partecipa_attivita()
{
    global $conn;

    if (isset($_POST['id_attivita']))
    {
        $stmt = $conn->prepare("SELECT * FROM Partecipa WHERE id_attivita = :id_attivita");
        $stmt->bind_param('id_attivita', $_POST['id_attivita'], PDO::PARAM_INT);
        $stmt_>execute();

        if ($row = stmt->fetch(PDO::FETCH_ASSOC))
        {
            echo json_encode($row);
            return;
        }
    }
    echo json_encode("error");
}


function insert_partecipa()
{
    global $conn;

    if(isset($_POST['id_unita']) && 
    isset($_POST['id_attivita']))
    {
        $stmt = $conn->prepare("INSERT INTO Partecipa (id_unita, id_attivita) VALUES (:id_unita, :id_attivita)");
        $stmt = $conn->bind_parama('id_unita', $_POST['id_unita'], PDO::PARAM_INT);
        $stmt = $conn->bind_param('id_attivita', $_POST['id_attivita'], PDO::PARAM_INT);
        $stmt->execute();

        if($stmt->rowCount() > 0)
        {
            echo json_encode("Successo");
            return;
        }
    }
    echo json_encode("error");
}

function update_partecipa()
{
    global $conn;

    [$_POST, $_FILES] = request_parse_body();

    if (isset($_POST['new_id_unita']) &&
        isset($_POST['new_id_attivita']) &&
        isset($_POST['old_id_unita']) &&
        isset($_POST['old_id_attivita']) 
        )
    {
        $stmt = $conn->prepare("UPDATE Partecipa SET id_unita = :new_id_unita, id_attivita = :new_id_attivita WHERE id_unita = :old_id_unita AND id_attivita = :old_id_attivita");

        $stmt->bind_param('new_id_unita', $_POST['new_id_unita'], PDO::PARAM_INT);
        $stmt->bind_param('new_id_attivita', $_POST['new_id_attivita'], PDO::PARAM_INT);
        $stmt->bind_param('old_id_unita', $_POST['old_id_unita'], PDO::PARAM_INT);
        $stmt->bind_param('old_id_attivita', $_POST['old_id_attivita'], PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0)
        {
            echo json_encode("Successo");
            return; 
        }
    }
    echo json_encode("error");
}
?>