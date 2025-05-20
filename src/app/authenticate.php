<?php
require_once'db.php';

function authenticateUser($username, $password){
    $sql_grossa ="SELECT Account.username, Servizio.descrizione FROM Persona
    JOIN Account ON Persona.id_perosna = Account.id_persona
    JOIN Servizio ON Servizio.id_persona = Persona.id_persona
    WHERE Account.username = '$username' AND Account.password = '$password'";
    $result = $conn->query($sql_grossa);

    if ($result->num_rows > 0) {
        return true;
    } else {
        die("Connessione al database fallita: " . $conn->connect_error);
    }

}

function canAccessTable($user_type, $tableName) {
    //Mappatura dei permessi: per ogni tipo di utente la lista delle tabelle accessibili
    $permissions = [
        'admin'   => ['users', 'orders', 'reports', 'logs'],  // gli admin hanno accesso a più tabelle
        'manager' => ['orders', 'reports'],
        'user'    => ['orders']
    ];

    if (isset($permissions[$user_type]) && in_array($tableName, $permissions[$user_type])) { //in_array(mixed $needle, array $haystack, bool $strict = false): bool
        return true;
    }
    return false;
}
?>