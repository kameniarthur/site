<?php
// Démarrer la session si ce n'est pas déjà fait
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$path = '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($pageTitle) ? $pageTitle : "Mon site éducatif"; ?></title>
    <link rel="stylesheet" href="/educatif/assets/css/style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
