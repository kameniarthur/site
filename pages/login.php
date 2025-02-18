<?php
require_once '../includes/User.php';
require_once '../includes/Session.php';
Session::init();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = trim($_POST['usernameOrEmail']);
    $password = trim($_POST['password']);

    $userObj = new User();
    $user = $userObj->login($usernameOrEmail, $password);

    if ($user) {
        // Enregistrer l'utilisateur dans la session
        $_SESSION['user'] = $user;
        header('Location: ../index.php');
        exit;
    } else {
        $error = "Identifiants incorrects";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>
    <?php if (isset($error)) echo '<p style="color:red;">' . $error . '</p>'; ?>
    <form action="" method="post">
        <label for="usernameOrEmail">Nom d'utilisateur ou Email :</label><br>
        <input type="text" name="usernameOrEmail" id="usernameOrEmail" required><br><br>
        <label for="password">Mot de passe :</label><br>
        <input type="password" name="password" id="password" required><br><br>
        <button type="submit">Se connecter</button>
    </form>
    <p>Pas encore inscrit ? <a href="register.php">Inscription</a></p>
</body>
</html>
