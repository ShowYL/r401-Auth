<?php

/**
 * Class Connection
 * 
 * This class is responsible for handling database connections.
 * 
 */
class Connection {

    private $conn;
    private $servername = "mysql-chatr410.alwaysdata.net"; 
    private $username = "chatr410";
    private $password = "\$iutinfo"; 
    private $dbname = "chatr410_bdauth";

    /**
     * Constructor for the database connection class.
     *
     * This constructor initializes a connection to the MySQL database using PDO.
     * It sets the connection attributes and handles any connection errors.
     *
     * @throws PDOException If the connection to the database fails.
     */
    public function __construct() {
        try {
            $dsn = "mysql:host=$this->servername;dbname=$this->dbname;charset=utf8";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("La connexion a échoué: " . $e->getMessage());
        }
    }

    /**
     * Retrieves the current database connection.
     *
     * @return mixed The current database connection.
     */
    public function getConnection() {
        return $this->conn;
    }

    /**
     * Closes the database connection.
     *
     * This method sets the provided connection object to null, effectively closing the connection.
     *
     * @param PDO|null $conn The database connection object to be closed.
     */
    public function close($conn) {
        $conn = null;
    }
}
?>