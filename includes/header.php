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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container m-5">