<?php
// Démarre la session si nécessaire
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

?>

<?php if (isset($_SESSION['user'])): ?>
<nav class="navbar navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Learn site</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Dark offcanvas</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
          <a href="<?php echo $path."upload_epreuve.php" ?>">Uploader une épreuve</a>
          </li>
          <li class="nav-item">
          <a href="<?php echo $path."view_epreuve.php"?>">Liste des épreuves</a>
          </li>
          <li class="nav-item">
          <a href="<?php echo $path."chat.php" ?>">Conversations</a>
          </li>
          <li class="nav-item">
           <a href="<?php echo $path."logout.php" ?>">Déconnexion</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
<?php else: ?>
            <li><a href="pages/login.php">Connexion</a></li>
            <li><a href="pages/register.php">Inscription</a></li>
<?php endif; ?>