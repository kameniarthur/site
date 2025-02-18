<?php
require_once 'db.php';

class User {
    private $pdo;

    public function __construct() {
        // Récupère l'instance PDO depuis notre classe Database (pattern Singleton)
        $this->pdo = Database::getInstance()->getConnection();
    }

    // Méthode pour inscrire un utilisateur
    public function register($username, $email, $password) {
        // On hache le mot de passe pour la sécurité
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->pdo->prepare($sql);

        try {
            $stmt->execute([
                ':username' => $username,
                ':email'    => $email,
                ':password' => $hashedPassword
            ]);
            // Retourne l'ID du nouvel utilisateur
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            // En production, on logerait l'erreur sans l'afficher directement
            return false;
        }
    }

    // Méthode pour connecter un utilisateur
    public function login($usernameOrEmail, $password) {
        $sql = "SELECT * FROM users WHERE username = :value OR email = :value";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':value' => $usernameOrEmail]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Ici, on pourrait démarrer la session et enregistrer les infos de l'utilisateur
            return $user;
        }
        return false;
    }

    // Méthode pour récupérer un utilisateur par son ID
    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
