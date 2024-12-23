 
<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createUser($email, $password) {
        $stmt = $this->pdo->prepare('INSERT INTO users (email, password) VALUES (?, ?)');
        return $stmt->execute([$email, $password]);
    }

    public function getUserByEmail($email) {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function emailExists($email) {
        $stmt = $this->pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch() ? true : false;
    }
}
?>
