<?php
require_once '../includes/require_login.php';
require_once '../includes/Forum.php';
$pageTitle = "Créer un sujet";
include '../includes/header.php';

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre']);
    $description = trim($_POST['description']);

    if (empty($titre) || empty($description)) {
        $error = "Veuillez remplir tous les champs.";
    } else {
        $forum = new Forum();
        $topic_id = $forum->createTopic($titre, $description, $_SESSION['user']['id']);
        if ($topic_id) {
            header("Location: view_topic.php?id=" . $topic_id);
            exit;
        } else {
            $error = "Erreur lors de la création du sujet.";
        }
    }
}
?>

<h1>Créer un nouveau sujet</h1>

<?php if ($error): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>

<form action="" method="post">
    <label for="titre">Titre :</label><br>
    <input type="text" id="titre" name="titre" required><br><br>
    
    <label for="description">Description :</label><br>
    <textarea id="description" name="description" required></textarea><br><br>
    
    <button type="submit">Créer le sujet</button>
</form>

<?php include '../includes/footer.php'; ?>
