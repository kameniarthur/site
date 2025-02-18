<?php
session_start();
$path = 'pages/';
$pageTitle = "Accueil";
include 'includes/header.php';
$username = isset($_SESSION['user']) ? $_SESSION['user']['username'] : 'Invité';
?>
<h1>Bienvenue, <?php echo htmlspecialchars($username); ?>!</h1>
<p>Ceci est la page d'accueil de votre site éducatif.</p>
<?php

include 'includes/footer.php'; 
?>
