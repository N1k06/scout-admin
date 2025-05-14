<?php
function insert_account()
{
    global $conn;

    if (isset($_POST['email']) && 
        isset($_POST['password']) && 
        isset($_POST['username']) && 
        isset($_POST['id_persona'])) 
    {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $query = "INSERT INTO Account (email, password, username, id_persona) VALUES (:email, :password, :username, :id_persona)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
        $stmt->bindParam(':id_persona', $_POST['id_persona'], PDO::PARAM_INT);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) 
        {
            echo json_encode($conn->lastInsertId());
            return;
        }
    }
    echo json_encode("error");
}

function read_account()
{
    global $conn;

    if (isset($_POST['username'])) 
    {
        $query = "SELECT * FROM Account WHERE username = :username";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
        $stmt->execute();
    
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
        {
            echo json_encode($row);
            return;
        }
    }
    echo json_encode("error");
}

function update_account()
{
    global $conn;

    [$_POST, $_FILES] = request_parse_body();

    if (isset($_POST['email']) && 
        isset($_POST['password']) && 
        isset($_POST['old_username']) && 
        isset($_POST['new_username']) && 
        isset($_POST['id_persona'])) 
    {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $query = "UPDATE Account SET email = :email, password = :password, username = :new_username, id_persona = :id_persona WHERE username = :old_username";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':old_username', $_POST['old_username'], PDO::PARAM_STR);
        $stmt->bindParam(':new_username', $_POST['new_username'], PDO::PARAM_STR);
        $stmt->bindParam(':id_persona', $_POST['id_persona'], PDO::PARAM_INT);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) 
        {
            echo json_encode("success");
            return;
        }
    }
    echo json_encode("error");
}
?>