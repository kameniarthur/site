<?php
require_once '../includes/require_login.php'; // Vérifie que l'utilisateur est connecté
require_once '../includes/Epreuves.php';
$pageTitle = "Uploader une épreuve"; // Pour le titre de la page
include '../includes/header.php';

// ... ton code pour gérer l'upload d'épreuve
$erreur = "";
$succes = "";
$userId = $_SESSION['user']['id']; // Utilisation de l'utilisateur connecté

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['epreuve']) && $_FILES['epreuve']['error'] === UPLOAD_ERR_OK) {
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $file = $_FILES['epreuve'];

        $epreuveObj = new Epreuve();
        if ($epreuveObj->upload($title, $description, $file, $userId)) {
            $succes = "Épreuve uploadée avec succès !";
        } else {
            $erreur = "Erreur lors de l'upload de l'épreuve.";
        }
    } else {
        $erreur = "Aucun fichier sélectionné ou erreur d'upload.";
    }
}
?>

<h1>Uploader une épreuve</h1>
<?php if ($succes): ?>
    <p style="color:green;"><?php echo $succes; ?></p>
<?php endif; ?>
<?php if ($erreur): ?>
    <p style="color:red;"><?php echo $erreur; ?></p>
<?php endif; ?>

<form action="" method="post" enctype="multipart/form-data">
    <label for="title">Titre :</label><br>
    <input type="text" id="title" name="title" required><br><br>

    <label for="description">Description :</label><br>
    <textarea id="description" name="description" required></textarea><br><br>

    <label for="epreuve">Fichier :</label><br>
    <input type="file" id="epreuve" name="epreuve" required><br><br>

    <button type="submit">Uploader</button>
</form>

<?php include '../includes/footer.php'; ?>
