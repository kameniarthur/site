<?php
require_once '../includes/Epreuves.php';

$epreuveObj = new Epreuve();
$epreuves = $epreuveObj->getEpreuves();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des épreuves</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .epreuve {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .epreuve h2 {
            margin-top: 0;
        }
        .btn {
            background-color: #4285f4;
            color: #fff;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <h1>Liste des épreuves</h1>

    <?php if (!empty($epreuves)): ?>
        <?php foreach ($epreuves as $epreuve): ?>
            <div class="epreuve">
                <h2><?php echo htmlspecialchars($epreuve['titre']); ?></h2>
                <p><?php echo nl2br(htmlspecialchars($epreuve['description'])); ?></p>
                <p>
                    <a class="btn" href="../<?php echo $epreuve['fichier']; ?>" target="_blank">Voir le fichier</a>
                </p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucune épreuve disponible pour le moment.</p>
    <?php endif; ?>

</body>
</html>
