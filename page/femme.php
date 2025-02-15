<?php
session_start();
require '../php/db.php'; // Assure-toi que ce fichier contient ta connexion PDO

// Récupérer les produits pour la catégorie "Homme"
$sql = "SELECT * FROM produit WHERE genre = 'Femme'";
$stmt = $pdo->query($sql);
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STOCK M - Homme</title>
    <link rel="stylesheet" href="../style/style.css">
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
        <div class="logo-container">
            <a href="../index.php"><img src="../image/stockm.jpg.webp" alt="logo STOCKM" id="logo"/></a>
        </div>
        <ul>
            <li><a href="homme.php">Homme</a></li>
            <li><a href="femme.php">Femme</a></li>
            <li><a href="enfant.php">Enfant</a></li>
        </ul>
        <ul>
            <li><a href="panier.php">Panier</a></li>
            <?php if (isset($_SESSION['user_email'])): ?>
                <li><a href="/Clientleger/php/deconnexion.php">Déconnexion</a></li>
            <?php else: ?>
                <li><a href="/Clientleger/page/connexion.html">Connexion</a></li>
            <?php endif; ?>
            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?>
                <li><a href="/Clientleger/page/admin.php">Ajouter un produit</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<div class="product-grid">
    <?php if (!empty($produits)): ?>
        <?php foreach ($produits as $produit): ?>
            <a href="chaussure.php?id_produit=<?= htmlspecialchars($produit['id_produit']) ?>">
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

</body>
</html>