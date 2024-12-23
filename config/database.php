<?php
class Database {
    private $host = '127.0.0.1';    // Database host
    private $db = 'music_platform'; // Database name
    private $user = 'root';         // Database username
    private $pass = '';             // Database password
    private $charset = 'utf8mb4';   // Character set
    private $pdo;

    public function __construct() {
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function getConnection() {
        return $this->pdo;
    }
}

// Instantiate the Database class and get the PDO connection
$database = new Database();
$pdo = $database->getConnection();
?>
