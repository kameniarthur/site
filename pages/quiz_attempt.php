<?php
require_once '../includes/require_login.php';
require_once '../includes/Quiz.php';
$pageTitle = "Passer le Quiz";
include '../includes/header.php';

$quizObj = new Quiz();
$userId = $_SESSION['user']['id'];

// Vérifie qu'un quiz est spécifié dans l'URL
if (!isset($_GET['quiz_id'])) {
    echo "<p>Quiz non spécifié.</p>";
    include '../includes/footer.php';
    exit;
}

$quizId = (int) $_GET['quiz_id'];
$quiz = $quizObj->getQuiz($quizId);
if (!$quiz) {
    echo "<p>Quiz introuvable.</p>";
    include '../includes/footer.php';
    exit;
}

$questions = $quizObj->getQuestions($quizId);
?>

<h1><?php echo htmlspecialchars($quiz['titre']); ?></h1>
<form action="attempt_quiz.php?quiz_id=<?php echo $quizId; ?>" method="post">
    <?php foreach ($questions as $question): ?>
        <div style="margin-bottom:20px;">
            <p><strong><?php echo htmlspecialchars($question['question']); ?></strong></p>
            <?php
            $answers = $quizObj->getAnswers($question['id']);
            foreach ($answers as $answer):
            ?>
                <label>
                    <input type="radio" name="answer[<?php echo $question['id']; ?>]" value="<?php echo $answer['id']; ?>" required>
                    <?php echo htmlspecialchars($answer['reponse']); ?>
                </label><br>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
    <button type="submit" name="submit">Valider le quiz</button>
</form>

<?php
if (isset($_POST['submit'])) {
    $userAnswers = $_POST['answer'];
    $score = $quizObj->processAttempt($quizId, $userId, $userAnswers);
    echo "<p>Votre score est : $score</p>";
}
?>

<?php include '../includes/footer.php'; ?>
