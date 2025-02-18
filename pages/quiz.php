<?php
require_once '../includes/require_login.php';
require_once '../includes/Quiz.php';
$pageTitle = "Liste des Quiz";
include '../includes/header.php';

$quizObj = new Quiz();
$quizzes = $quizObj->getQuizzes();
?>

<h1>Liste des Quiz</h1>
<?php if ($quizzes): ?>
    <ul>
        <?php foreach ($quizzes as $quiz): ?>
            <li>
                <a href="attempt_quiz.php?quiz_id=<?php echo $quiz['id']; ?>">
                    <?php echo htmlspecialchars($quiz['titre']); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Aucun quiz disponible pour le moment.</p>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
