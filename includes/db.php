<?php
class Database {
    // Instance unique de la classe
    private static $instance = null;
    // Objet PDO qui va gérer la connexion
    private $pdo;

    // Constructeur privé pour empêcher la création directe d'instances
    private function __construct() {
        $host = 'localhost';
        $dbname = 'educatif';
        $username = 'root';
        $password = '';

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    // Méthode statique pour obtenir l'instance unique
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Méthode pour récupérer l'objet PDO
    public function getConnection() {
        return $this->pdo;
    }
}
?>
