<?php
require_once 'db.php';

class Quiz {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    // Récupère la liste de tous les quiz
    public function getQuizzes() {
        $sql = "SELECT * FROM quiz ORDER BY date_creation DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère un quiz spécifique par son ID
    public function getQuiz($quizId) {
        $sql = "SELECT * FROM quiz WHERE id = :quizId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':quizId' => $quizId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupère toutes les questions d'un quiz
    public function getQuestions($quizId) {
        $sql = "SELECT * FROM questions WHERE quiz_id = :quizId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':quizId' => $quizId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère toutes les réponses pour une question donnée
    public function getAnswers($questionId) {
        $sql = "SELECT * FROM reponses WHERE question_id = :questionId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':questionId' => $questionId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Traite une tentative de quiz : calcule le score, enregistre la tentative et renvoie le score
    // $userAnswers est un tableau associatif : question_id => réponse_id sélectionnée
    public function processAttempt($quizId, $userId, $userAnswers) {
        $score = 0;
        // Récupère toutes les questions du quiz
        $questions = $this->getQuestions($quizId);
        foreach ($questions as $question) {
            $qId = $question['id'];
            if (isset($userAnswers[$qId])) {
                $selectedAnswerId = $userAnswers[$qId];
                // Vérifier si la réponse sélectionnée est correcte
                $sql = "SELECT est_correct FROM reponses WHERE id = :answerId";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([':answerId' => $selectedAnswerId]);
                $answer = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($answer && $answer['est_correct']) {
                    $score++;
                }
            }
        }
        // Enregistre la tentative dans la table 'tentatives'
        $sql = "INSERT INTO tentatives (user_id, quiz_id, score) VALUES (:user_id, :quiz_id, :score)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $userId,
            ':quiz_id' => $quizId,
            ':score'   => $score
        ]);
        return $score;
    }
}
?>
