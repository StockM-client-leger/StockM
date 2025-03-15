<?php
session_start();
// En haut du fichier, après session_start()
$redirect = isset($_GET['redirect']) ? htmlspecialchars($_GET['redirect']) : '/Clientleger/index.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STOCK M</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="../script/script.js" defer></script>
</head>

<body>

    <div id="mouse-light"></div>

  <div aria-disabled id="hidden-text">
    <h1>StockM Sneakers</h1>
    <h1>Sneakers StockM</h1>
    <h1>Air Jordan 4 Dunk Low</h1>
    <h1>Dunk Low Air Jordan 4</h1>
    <h1>Air Max Plus Dunk Low</h1>
    <h1>NB 1906R Air Max Plus</h1>
    <h1>Air Force One NB 1906R</h1>
  </div>


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


<main class="container">
    <section id="connexion-form">
        <h2>Connexion à votre compte</h2>
        
        <?php if(isset($_GET['error']) && $_GET['error'] == 1): ?>
            <div class="alert-error">
                Email ou mot de passe incorrect !
            </div>
        <?php endif; ?>

        <form action="../php/connexion.php?redirect=<?php echo urlencode($redirect); ?>" method="post" id="login-form">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Entrez votre email" required>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Entrez votre mot de passe" required>
            </div>
            <button type="submit" class="btn">Se connecter</button>
            
            <a href="inscription2.php" style="margin-top: 10px; display: block; color: #ecd90c !important;">Pas encore inscrit ? S'inscrire</a>
            
        </form>
    </section>
</main>

<style>
.alert-error {
    background-color: rgba(255, 0, 0, 0.1);
    border: 1px solid #ff0000;
    color: #ff0000;
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
    text-align: center;
}
</style>

<footer class="footer">
    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> STOCK M - Tous droits réservés</p>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('login-form');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('mot_de_passe');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let isValid = true;

        // Validation email
        if (!emailInput.value) {
            alert('L\'email est requis');
            isValid = false;
            return;
        }

        if (!isValidEmail(emailInput.value)) {
            alert('Format d\'email invalide');
            isValid = false;
            return;
        }

        // Validation mot de passe
        if (!passwordInput.value) {
            alert('Le mot de passe est requis');
            isValid = false;
            return;
        }

        if (passwordInput.value.length < 8) {
            alert('Le mot de passe doit contenir au moins 8 caractères dont une majuscule et un caractère spécial');
            isValid = false;
            return;
        }

        // Si tout est valide, soumettre le formulaire
        if (isValid) {
            this.submit();
        }
    });

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
});
</script>

</body>
</html>