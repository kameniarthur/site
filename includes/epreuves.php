<?php
require_once 'db.php';

class Epreuve {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    /**
     * Upload d'une épreuve.
     * 
     * @param string $title       Titre de l'épreuve
     * @param string $description Description de l'épreuve
     * @param array  $file        Fichier provenant de $_FILES
     * @param int    $userId      ID de l'utilisateur qui upload
     * @return bool               True en cas de succès, false sinon
     */
    public function upload($title, $description, $file, $userId) {
        // Dossier de destination
        $targetDir = "uploads/epreuves/";
        // On nettoie le nom du fichier pour éviter les soucis
        $filename = basename($file['name']);
        $targetFile = $targetDir . $filename;

        // Vérifier que le dossier existe (sinon, on le crée)
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Déplacer le fichier uploadé dans le dossier de destination
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            $sql = "INSERT INTO epreuves (titre, description, fichier, user_id) VALUES (:titre, :description, :fichier, :user_id)";
            $stmt = $this->pdo->prepare($sql);
            try {
                $stmt->execute([
                    ':titre'       => $title,
                    ':description' => $description,
                    ':fichier'     => $targetFile,
                    ':user_id'     => $userId
                ]);
                return true;
            } catch (PDOException $e) {
                // En production, pensez à logguer l'erreur plutôt que de l'afficher
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Récupérer toutes les épreuves.
     * 
     * @return array Tableau associatif des épreuves
     */
    public function getEpreuves() {
        $sql = "SELECT * FROM epreuves ORDER BY date_upload DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupérer une épreuve par son ID.
     *
     * @param int $id ID de l'épreuve
     * @return array|false Tableau associatif de l'épreuve ou false si non trouvé
     */
    public function getEpreuve($id) {
        $sql = "SELECT * FROM epreuves WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
