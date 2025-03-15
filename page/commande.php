<?php
session_start();
require_once '../php/db.php';

if (!isset($_SESSION['user_email']) || !isset($_SESSION['id_utilisateur'])) {
    header("Location: connexion2.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['total'])) {
    header("Location: panier.php");
    exit();
}

$total = floatval($_POST['total']);

// Récupérer les informations de l'utilisateur
$query = "SELECT * FROM utilisateur WHERE id_utilisateur = :id";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $_SESSION['id_utilisateur']]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finaliser la commande</title>
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

    <div class="commande-container">
        <h1>Finaliser votre commande</h1>
        
        <form action="../php/valider_commande.php" method="POST" class="commande-form">
            <div class="form-section">
                <h2>Adresse de livraison</h2>
                <div class="form-group">
                    <label for="adresse">Adresse</label>
                    <input type="text" id="adresse" name="adresse" required>
                </div>
                <div class="form-group">
                    <label for="code_postal">Code Postal</label>
                    <input type="text" id="code_postal" name="code_postal" required pattern="[0-9]{5}">
                </div>
                <div class="form-group">
                    <label for="ville">Ville</label>
                    <input type="text" id="ville" name="ville" required>
                </div>
            </div>

            <div class="form-section">
                <h2>Mode de livraison</h2>
                <div class="radio-group">
                    <div>
                        <input type="radio" id="standard" name="livraison" value="standard" checked>
                        <label for="standard">Standard (3-5 jours) - Gratuit</label>
                    </div>
                    <div>
                        <input type="radio" id="express" name="livraison" value="express">
                        <label for="express">Express (1-2 jours) - 9.99€</label>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h2>Récapitulatif</h2>
                <div class="recap">
                    <p>Total produits : <span><?php echo number_format($total, 2, ',', ' '); ?> €</span></p>
                    <p>Frais de livraison : <span id="frais-livraison">0,00 €</span></p>
                    <p class="total">Total final : <span id="total-final"><?php echo number_format($total, 2, ',', ' '); ?> €</span></p>
                </div>
            </div>

            <input type="hidden" name="total" value="<?php echo $total; ?>">
            <button type="submit" class="btn-valider">Confirmer la commande</button>
        </form>
    </div>

    <style>
    /* ... Ajoutez ici le style CSS ... */
    </style>

    <script>
    document.querySelectorAll('input[name="livraison"]').forEach(input => {
        input.addEventListener('change', function() {
            const fraisLivraison = this.value === 'express' ? 9.99 : 0;
            const total = <?php echo $total; ?>;
            const totalFinal = total + fraisLivraison;
            
            document.getElementById('frais-livraison').textContent = fraisLivraison.toFixed(2) + ' €';
            document.getElementById('total-final').textContent = totalFinal.toFixed(2) + ' €';
        });
    });
    </script>
</body>
</html>