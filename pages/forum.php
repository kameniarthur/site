<?php
require_once '../includes/require_login.php';
require_once '../includes/Forum.php';
$pageTitle = "Forum";
include '../includes/header.php';

$forum = new Forum();
$topics = $forum->getTopics();
?>

<h1>Forum</h1>
<p><a href="create_topic.php">Créer un nouveau sujet</a></p>

<?php if ($topics): ?>
    <?php foreach ($topics as $topic): ?>
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px; border-radius:5px;">
            <h2>
                <a href="view_topic.php?id=<?php echo $topic['id']; ?>">
                    <?php echo htmlspecialchars($topic['titre']); ?>
                </a>
            </h2>
            <p><?php echo nl2br(htmlspecialchars($topic['description'])); ?></p>
            <p>
                <small>Créé par <?php echo htmlspecialchars($topic['username']); ?> 
                le <?php echo $topic['date_creation']; ?></small>
            </p>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Aucun sujet pour le moment.</p>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
