<?php
function insert_pagamento()
{
    global $conn;

    if (isset($_POST['importo']) && 
        isset($_POST['metodo']) && 
        isset($_POST['data'])) 
    {
        $query = "INSERT INTO Pagamento (importo, metodo, data) VALUES (:importo, :metodo, :data)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':importo', $_POST['importo'], PDO::PARAM_INT);
        $stmt->bindParam(':metodo', $_POST['metodo'], PDO::PARAM_STR);
        $stmt->bindParam(':data', $_POST['data'], PDO::PARAM_STR);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) 
        {
            echo json_encode($conn->lastInsertId());
            return;
        }
    }
    echo json_encode("error");
}

function read_pagamento($id_pagamento)
{
    global $conn;

    if (isset($_POST['id_pagamento'])) 
    {
        $query = "SELECT * FROM Pagamento WHERE id_pagamento = :id_pagamento";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_pagamento', $id_pagamento, PDO::PARAM_INT);
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