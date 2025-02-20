<?php
require_once '../includes/Epreuves.php';

$epreuveObj = new Epreuve();
$epreuves = $epreuveObj->getEpreuves();
require_once '../includes/header.php';
?>

    <h1 class="text-center m-2 ">Liste des épreuves</h1>
    <div class="row d-flex align-items-center jutify-content-center mt-5 ">
        <?php if (!empty($epreuves)): ?>
        <?php foreach ($epreuves as $epreuve): ?>
            
            <div class="card m-1" style="width: 13rem;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($epreuve['titre']); ?></h5>
                    <p class="card-text"><?php echo nl2br(htmlspecialchars($epreuve['description'])); ?></p>
                    <a href="../<?php echo $epreuve['fichier']; ?> target="_blank" class="btn btn-primary">Voir le contenu</a>
                </div>
            </div>
            
        <?php endforeach; ?>
        <?php else: ?>
            
             <p>Aucune épreuve disponible pour le moment.</p>
        <?php endif; ?>
    </div>
</body>
</html>
