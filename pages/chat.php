<?php
ob_start();
require_once '../includes/require_login.php';
require_once '../includes/Message.php';
require_once '../includes/db.php';
$pageTitle = "Messagerie Privée";
include '../includes/header.php';

$messageObj   = new Message();
$currentUserId = $_SESSION['user']['id'];
$currentUsername = $_SESSION['user']['username'];
$pdo = Database::getInstance()->getConnection();

// Gestion de l'envoi de message
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $destinataire = isset($_POST['destinataire']) ? (int)$_POST['destinataire'] : 0;
    $msg = trim($_POST['message']);
    if (!empty($msg) && $destinataire > 0) {
        $messageObj->sendMessage($currentUserId, $destinataire, $msg);
        // Redirige pour éviter le repost et actualiser la conversation
        header("Location: chat.php?user_id=" . $destinataire);
        exit;
    }
}

// Vérifie si une conversation est sélectionnée
$otherUserId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
?>

<?php if ($otherUserId > 0): ?>
    <?php
    // Récupère la conversation entre l'utilisateur connecté et l'autre utilisateur
    $conversation = $messageObj->getConversation($currentUserId, $otherUserId);

    // Récupère le nom de l'autre utilisateur
    $stmt = $pdo->prepare("SELECT username FROM users WHERE id = :id");
    $stmt->execute([':id' => $otherUserId]);
    $otherUser = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <h1>Conversation avec <?php echo htmlspecialchars($otherUser['username']); ?></h1>
    <div style="border:1px solid #ccc; padding:10px; height:300px; overflow-y:scroll;">
        <?php if ($conversation): ?>
            <?php foreach ($conversation as $msg): ?>
                <p>
                    <strong><?php echo htmlspecialchars($msg['sender']); ?> :</strong>
                    <?php echo htmlspecialchars($msg['message']); ?>
                    <small>(<?php echo $msg['date_envoi']; ?>)</small>
                </p>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun message dans cette conversation.</p>
        <?php endif; ?>
    </div>
    <form action="" method="post" style="margin-top:10px;">
        <input type="hidden" name="destinataire" value="<?php echo $otherUserId; ?>">
        <textarea name="message" placeholder="Votre message..." required style="width:100%; height:80px;"></textarea><br>
        <button type="submit">Envoyer</button>
    </form>
    <p><a href="chat.php">Retour à la liste des conversations</a></p>

<?php else: ?>
    <h1>Vos Conversations</h1>
    <?php
    // Récupère la liste des conversations
    $conversations = $messageObj->getConversations($currentUserId);
    ?>
    <?php if ($conversations): ?>
        <ul>
            <?php foreach ($conversations as $conv): 
                $otherId = $conv['other_user_id'];
                $stmt = $pdo->prepare("SELECT username FROM users WHERE id = :id");
                $stmt->execute([':id' => $otherId]);
                $otherUser = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <li>
                    <a href="chat.php?user_id=<?php echo $otherId; ?>">
                        <?php echo htmlspecialchars($otherUser['username']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucune conversation pour le moment.</p>
    <?php endif; ?>

    <h2>Envoyer un nouveau message</h2>
    <form action="" method="post">
        <label for="destinataire">ID du destinataire :</label>
        <input type="number" name="destinataire" id="destinataire" required><br><br>
        <textarea name="message" placeholder="Votre message..." required style="width:100%; height:80px;"></textarea><br>
        <button type="submit">Envoyer</button>
    </form>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
<?php ob_end_flush(); ?>
