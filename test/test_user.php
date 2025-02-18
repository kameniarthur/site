<?php
require_once '../includes/User.php';

// Instancier la classe User
$userObj = new User();

// --- Test d'inscription ---
$registration = $userObj->register('JohnDoe', 'john@example.com', 'secret');
if ($registration) {
    echo "Inscription réussie ! L'ID de l'utilisateur est : " . $registration . "<br>";
} else {
    echo "Erreur lors de l'inscription.<br>";
}

// --- Test de connexion ---
$user = $userObj->login('JohnDoe', 'secret');
if ($user) {
    echo "Connexion réussie ! Bienvenue " . $user['username'] . " !";
} else {
    echo "Identifiants incorrects.";
}
?>
