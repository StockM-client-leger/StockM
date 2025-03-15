<?php
session_start();
require '../php/db.php'; // Assure-toi que ce fichier contient ta connexion PDO

// Récupérer les produits pour la catégorie "Femme"
$sql = "SELECT * FROM modele WHERE genre = 'Femme'";
$stmt = $pdo->query($sql);
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
// Ajouter au début de chaque fichier, juste après session_start()
function isCurrentPage($page) {
    return strpos($_SERVER['PHP_SELF'], $page) !== false;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STOCK M - [Catégorie]</title>
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
                <li><a href="/Clientleger/index.php" class="<?php echo isCurrentPage('index.php') ? 'active' : ''; ?>">
                    <i class="fas fa-home"></i> Accueil
                </a></li>
                <li><a href="/Clientleger/page/homme.php" class="<?php echo isCurrentPage('homme.php') ? 'active' : ''; ?>">
                    Homme
                </a></li>
                <li><a href="/Clientleger/page/femme.php" class="<?php echo isCurrentPage('femme.php') ? 'active' : ''; ?>">
                    Femme
                </a></li>
                <li><a href="/Clientleger/page/enfant.php" class="<?php echo isCurrentPage('enfant.php') ? 'active' : ''; ?>">
                    Enfant
                </a></li>
            </ul>
        </div>
        
        <ul class="user-links">
            <li><a href="/Clientleger/page/panier.php" class="<?php echo isCurrentPage('panier.php') ? 'active' : ''; ?>">
                <i class="fas fa-shopping-cart"></i> Panier
            </a></li>
            <?php if (isset($_SESSION['user_email'])): ?>
                <li><a href="/Clientleger/page/profil.php" class="<?php echo isCurrentPage('profil.php') ? 'active' : ''; ?>">
                    <i class="fas fa-user"></i> Mon Profil
                </a></li>
                <li><a href="/Clientleger/php/deconnexion.php">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </a></li>
                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?>
                    <li><a href="/Clientleger/page/admin.php" class="<?php echo isCurrentPage('admin.php') ? 'active' : ''; ?>">
                        <i class="fas fa-cog"></i> Administration
                    </a></li>
                <?php endif; ?>
            <?php else: ?>
                <li><a href="/Clientleger/page/connexion2.php"><i class="fas fa-sign-in-alt"></i> Connexion</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<div class="product-grid">
    <?php if (!empty($produits)): ?>
        <?php foreach ($produits as $produit): ?>
            <a href="chaussure.php?id_modele=<?= htmlspecialchars($produit['id_modele']) ?>&origine=femme">
                <div class="product">
                    <img src="<?= htmlspecialchars($produit['lien']) ?>" alt="<?= htmlspecialchars($produit['nom']) ?>">

                    <?php if (!empty($produit['meilleur_vente']) && $produit['meilleur_vente'] == 1): ?>
                        <div class="badge">Meilleure vente</div>
                    <?php endif; ?>

                    <div class="product-title"><?= htmlspecialchars($produit['nom']) ?></div>
                    <div class="product-price">
                        <?php if (!empty($produit['prix_promo']) && $produit['prix_promo'] > 0): ?>
                            <span class="discount"><?= number_format($produit['prix_promo'], 2) ?> &euro;</span>
                            <span class="original-price"><?= number_format($produit['prix'], 2) ?> &euro;</span>
                            <?php if ($produit['prix_promo'] < $produit['prix']): ?>
                                <div class="discount">
                                    <?= round(100 - ($produit['prix_promo'] / $produit['prix'] * 100)) ?>% de réduction
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <?= number_format($produit['prix'], 2) ?> &euro;
                        <?php endif; ?>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun produit disponible pour cette catégorie.</p>
    <?php endif; ?>
</div>
<footer class="footer">
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> STOCK M - Tous droits réservés</p>
        </div>
    </footer>
</body>
</html>