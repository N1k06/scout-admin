<?php
require_once'db.php';

function authenticateUser($username, $password){
    
    $sql_grossa ="SELECT Account.username, Servizio.descrizione FROM Persona
    JOIN Account ON Persona.id_perosna = Account.id_persona
    JOIN Servizio ON Servizio.id_persona = Persona.id_persona
    WHERE Account.username = '$username' AND Account.password = '$password'";
    
    $result = $conn->query($sql_grossa);
    
    if ($result->num_rows > 0) {
        $user_type= $result->fetch_assoc();
    } else {
        die("Connessione al database fallita: " . $conn->connect_error);
    }
    return $user_type;
}

function canAccessTable($user_type, $functionName) {
    //Mappatura dei permessi: per ogni tipo di utente la lista delle tabelle accessibili
    $permissions = [    
            'minorenne' => [
                '/api/persona' => ['read_persona'],
                '/api/unita' => ['read_unita'],
                '/api/iscrizione' => ['read_iscrizione'],
             ],
             'maggiorenne' => [
                '/api/account' => ['insert_account', 'update_account','read_account'],
                '/api/persona' => ['insert_persona', 'update_persona','read_persona'],
                '/api/iscrizione' => ['read_iscrizione']
            ]
    ];

    if (isset($permissions[$user_type]) && in_array($functionName, $permissions[$user_type])) { //in_array(mixed $needle, array $haystack, bool $strict = false): bool
        return true;
    }
    return false;
}
?>