<?php
function insert_attivita()
{
    global $conn;

    if (isset($_POST["nome"]) &&
       isset($_POST["data"]) &&
       isset($_POST["id_persona"]) &&
       isset($_POST["luogo_partenza"]) &&
       isset($_POST["luogo_arrivo"]))
    {
        $nome = $_POST["nome"];
        $data = $_POST["data"];
        $id_persona = $_POST["id_persona"];
        $luogo_partenza = $_POST["luogo_partenza"];
        $luogo_arrivo = $_POST["luogo_arrivo"];

        $query = "INSERT INTO Attivita (nome, data, luogo_partenza, luogo_arrivo) VALUES (:nome, :data, :luogo_partenza, :luogo_arrivo)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':data', $data, PDO::PARAM_STR);
        $stmt->bindParam(':luogo_partenza', $luogo_partenza, PDO::PARAM_STR);
        $stmt->bindParam(':luogo_arrivo', $luogo_arrivo, PDO::PARAM_STR);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) 
        {
            echo json_encode($conn->lastInsertId());
            return;
        }
    }
    echo json_encode("error");
}

function update_attivita()
{
    global $conn;

    [$_POST, $_FILES] = request_parse_body();

    if (isset($_POST["nome"]) &&
       isset($_POST["data"]) &&
       isset($_POST["id_persona"]) &&
       isset($_POST["luogo_partenza"]) &&
       isset($_POST["luogo_arrivo"]) &&
       isset($_POST["id_attivita"]))
    {
        $query = "UPDATE Attivita SET nome = :nome, data = :data, luogo_partenza = :luogo_partenza, luogo_arrivo = :luogo_arrivo WHERE id_attivita = :id_attivita";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nome', $_POST["nome"], PDO::PARAM_STR);
        $stmt->bindParam(':data', $_POST["data"];, PDO::PARAM_STR);
        $stmt->bindParam(':luogo_partenza', $_POST["luogo_partenza"], PDO::PARAM_STR);
        $stmt->bindParam(':luogo_arrivo', $_POST["luogo_arrivo"], PDO::PARAM_STR);
        $stmt->bindParam(':id_attivita', $_POST["id_attivita"], PDO::PARAM_INT);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) 
            echo json_encode("success");
        else
            echo json_encode("error");
        return;
    }
    else
    {
        echo json_encode("error");
        return;
    }
}

function read_attivita($id_attivita) 
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM Attivita NATURAL JOIN Persona NATURAL JOIN Partecipa NATURAL JOIN Unita NATURAL JOIN Branca WHERE id_attivita = :id");
    $stmt->bindParam(':id', $id_attivita, PDO::PARAM_INT);

    // Esegui
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result)
    {
        echo json_encode($result);
        return;
    }
    echo json_encode("error");
}
?>