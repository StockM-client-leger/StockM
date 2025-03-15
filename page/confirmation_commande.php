<?php
session_start();
require_once '../php/db.php';

if (!isset($_SESSION['user_email'])) {
    header("Location: connexion2.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de commande</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="nav-section">
                <div class="logo-container">
                    <a href="/Clientleger/index.php">
                        <img src="/Clientleger/image/stockm.jpg.webp" alt="logo STOCKM" id="logo" />
                    </a>
                </div>
                <ul class="main-links">
                    <li><a href="/Clientleger/index.php"><i class="fas fa-home"></i> Accueil</a></li>
                    <li><a href="/Clientleger/page/homme.php">Homme</a></li>
                    <li><a href="/Clientleger/page/femme.php">Femme</a></li>
                    <li><a href="/Clientleger/page/enfant.php">Enfant</a></li>
                </ul>
            </div>
            
            <ul class="user-links">
                <li><a href="/Clientleger/page/panier.php"><i class="fas fa-shopping-cart"></i> Panier</a></li>
                <?php if (isset($_SESSION['user_email'])): ?>
                    <li><a href="/Clientleger/page/profil.php"><i class="fas fa-user"></i> Mon Profil</a></li>
                    <li><a href="/Clientleger/php/deconnexion.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?>
                        <li><a href="/Clientleger/page/admin.php"><i class="fas fa-cog"></i> Administration</a></li>
                    <?php endif; ?>
                <?php else: ?>
                    <li><a href="/Clientleger/page/connexion2.php"><i class="fas fa-sign-in-alt"></i> Connexion</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <div class="confirmation-container">
        <div class="confirmation-message">
            <h1>Commande confirmée !</h1>
            <p>Merci pour votre commande. Elle a été enregistrée avec succès.</p>
            <p>Un email de confirmation vous sera envoyé prochainement.</p>
            <div class="confirmation-actions">
                <a href="../index.php" class="btn-retour">Retour à l'accueil</a>
            </div>
        </div>
    </div>
</body>
</html>