<?php
require_once '../includes/require_login.php';
require_once '../includes/Forum.php';
$pageTitle = "Voir le sujet";
include '../includes/header.php';

$forum = new Forum();

if (isset($_GET['id'])) {
    $topic_id = (int) $_GET['id'];
    $topic = $forum->getTopic($topic_id);
    if (!$topic) {
        echo "<p>Sujet introuvable.</p>";
        include '../includes/footer.php';
        exit;
    }
    $messages = $forum->getMessages($topic_id);

    $error = "";
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
        $message = trim($_POST['message']);
        if (empty($message)) {
            $error = "Votre message est vide.";
        } else {
            $forum->addMessage($topic_id, $_SESSION['user']['id'], $message);
            header("Location: view_topic.php?id=" . $topic_id);
            exit;
        }
    }
} else {
    echo "<p>ID du sujet manquant.</p>";
    include '../includes/footer.php';
    exit;
}
?>

<h1><?php echo htmlspecialchars($topic['titre']); ?></h1>
<p><?php echo nl2br(htmlspecialchars($topic['description'])); ?></p>
<p><small>Créé par <?php echo htmlspecialchars($topic['username']); ?> le <?php echo $topic['date_creation']; ?></small></p>

<hr>

<h2>Messages</h2>
<?php if ($messages): ?>
    <?php foreach ($messages as $msg): ?>
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px; border-radius:5px;">
            <p><?php echo nl2br(htmlspecialchars($msg['message'])); ?></p>
            <p><small>Par <?php echo htmlspecialchars($msg['username']); ?> le <?php echo $msg['date_message']; ?></small></p>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Aucun message pour le moment.</p>
<?php endif; ?>

<hr>

<h2>Ajouter un message</h2>
<?php if ($error): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>
<form action="" method="post">
    <textarea name="message" required style="width:100%; height:100px;"></textarea><br><br>
    <button type="submit">Envoyer</button>
</form>

<?php include '../includes/footer.php'; ?>
