<?php
require_once '../includes/User.php';
require_once '../includes/Session.php';
Session::init();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    $userObj = new User();
    $result = $userObj->register($username, $email, $password);

    if ($result) {
        // Récupérer les informations de l'utilisateur pour la session
        $_SESSION['user'] = $userObj->getUserById($result);
        header('Location: ../index.php');
        exit;
    } else {
        $error = "Erreur lors de l'inscription. Vérifiez que le nom d'utilisateur ou l'email n'est pas déjà utilisé.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>
    <?php if (isset($error)) echo '<p style="color:red;">' . $error . '</p>'; ?>
    <form action="" method="post">
        <label for="username">Nom d'utilisateur :</label><br>
        <input type="text" name="username" id="username" required><br><br>
        <label for="email">Email :</label><br>
        <input type="email" name="email" id="email" required><br><br>
        <label for="password">Mot de passe :</label><br>
        <input type="password" name="password" id="password" required><br><br>
        <button type="submit">S'inscrire</button>
    </form>
    <p>Déjà inscrit ? <a href="login.php">Connexion</a></p>
</body>
</html>
