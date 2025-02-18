<?php
require_once 'db.php';

class Message {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    /**
     * Envoie un message d'un utilisateur à un autre.
     *
     * @param int $expediteur_id ID de l'expéditeur.
     * @param int $destinataire_id ID du destinataire.
     * @param string $message Le contenu du message.
     * @return bool Vrai en cas de succès, faux sinon.
     */
    public function sendMessage($expediteur_id, $destinataire_id, $message) {
        $sql = "INSERT INTO messages_prives (expediteur_id, destinataire_id, message)
                VALUES (:expediteur_id, :destinataire_id, :message)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':expediteur_id'    => $expediteur_id,
            ':destinataire_id'  => $destinataire_id,
            ':message'          => $message
        ]);
    }

    /**
     * Récupère la conversation entre deux utilisateurs.
     *
     * @param int $userId ID du premier utilisateur (celui connecté).
     * @param int $otherUserId ID de l'autre utilisateur.
     * @return array Tableau associatif des messages.
     */
    public function getConversation($userId, $otherUserId) {
        $sql = "SELECT mp.*, u.username AS sender 
                FROM messages_prives mp 
                JOIN users u ON mp.expediteur_id = u.id 
                WHERE (expediteur_id = :userId AND destinataire_id = :otherUserId)
                   OR (expediteur_id = :otherUserId AND destinataire_id = :userId)
                ORDER BY date_envoi ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':userId'      => $userId,
            ':otherUserId' => $otherUserId
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère la liste des utilisateurs avec lesquels l'utilisateur connecté a échangé des messages.
     *
     * @param int $userId ID de l'utilisateur connecté.
     * @return array Liste des identifiants des autres utilisateurs.
     */
    public function getConversations($userId) {
        $sql = "SELECT DISTINCT 
                    CASE 
                        WHEN expediteur_id = :userId THEN destinataire_id 
                        ELSE expediteur_id 
                    END as other_user_id
                FROM messages_prives
                WHERE expediteur_id = :userId OR destinataire_id = :userId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
