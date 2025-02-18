<?php
// Démarre la session si nécessaire
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

?>
<nav>
    <ul>
        <li><a href="/educatif/index.php">Accueil</a></li>
        <?php if (isset($_SESSION['user'])): ?>
            <li><a href="<?php echo $path."upload_epreuve.php" ?> ">Uploader une épreuve</a></li>
            <li><a href="<?php echo $path."view_epreuve.php" ?>">Liste des épreuves</a></li>
            <li><a href="<?php echo $path."logout.php" ?>">Déconnexion</a></li>
        <?php else: ?>
            <li><a href="pages/login.php">Connexion</a></li>
            <li><a href="pages/register.php">Inscription</a></li>
        <?php endif; ?>
    </ul>
</nav>
