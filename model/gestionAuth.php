<?php
require_once '../connection/connection.php';

$con = getDBCon();

/**
 * Creates a new user with the given username and password.
 *
 * @param string $nomUtilisateur The username of the new user.
 * @param string $password The password for the new user.
 * @return bool Returns true if the user was created successfully, false otherwise.
 */
function createUser(string $nomUtilisateur, string $password)
{
    global $con;
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $con->prepare("INSERT INTO User (Password, Nom_Utilisateur) VALUES (:password, :nomUtilisateur)");
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':nomUtilisateur', $nomUtilisateur);
    return $stmt->execute();
}

/**
 * Retrieve user information based on the username.
 *
 * @param string $nomUtilisateur The username of the user to retrieve.
 * @return array|null The user information as an associative array, or null if the user is not found.
 */
function getUser(string $nomUtilisateur, string $password)
{
    global $con;    $stmt = $con->prepare("SELECT ID_User,Password FROM User WHERE Nom_Utilisateur = :nomUtilisateur");
    $stmt->bindParam(':nomUtilisateur', $nomUtilisateur);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        if ($row && password_verify($password, $row['Password'])) {
            return array("id" => $row['ID_User']);
        }
    }
    return null;
}


?>