<?php
require_once 'db.php';

class Forum {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    // Récupère tous les sujets du forum, avec le nom de l'auteur
    public function getTopics() {
        $sql = "SELECT fs.*, u.username 
                FROM forum_sujets fs 
                JOIN users u ON fs.user_id = u.id 
                ORDER BY fs.date_creation DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crée un nouveau sujet
    public function createTopic($titre, $description, $user_id) {
        $sql = "INSERT INTO forum_sujets (titre, description, user_id) 
                VALUES (:titre, :description, :user_id)";
        $stmt = $this->pdo->prepare($sql);
        if ($stmt->execute([
            ':titre'       => $titre,
            ':description' => $description,
            ':user_id'     => $user_id
        ])) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    // Récupère un sujet spécifique
    public function getTopic($id) {
        $sql = "SELECT fs.*, u.username 
                FROM forum_sujets fs 
                JOIN users u ON fs.user_id = u.id 
                WHERE fs.id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupère les messages d'un sujet
    public function getMessages($sujet_id) {
        $sql = "SELECT fm.*, u.username 
                FROM forum_messages fm 
                JOIN users u ON fm.user_id = u.id 
                WHERE fm.sujet_id = :sujet_id 
                ORDER BY fm.date_message ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':sujet_id' => $sujet_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajoute un message dans un sujet
    public function addMessage($sujet_id, $user_id, $message) {
        $sql = "INSERT INTO forum_messages (sujet_id, user_id, message) 
                VALUES (:sujet_id, :user_id, :message)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':sujet_id' => $sujet_id,
            ':user_id'  => $user_id,
            ':message'  => $message
        ]);
    }
}
?>
