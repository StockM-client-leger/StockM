<?php
require_once '../php/db.php'; // Assure-toi que ce chemin est correct

// Vérifie si l'ID est bien passé dans l'URL
if (isset($_GET['id_produit'])) {
    $product_id = intval($_GET['id_produit']); // Convertit en entier pour éviter les erreurs
} else {
    die("ID du produit manquant."); // Arrête l'exécution et affiche un message d'erreur
}

// Connexion à la base de données avec PDO
try {
    $stmt = $pdo->prepare("SELECT id_produit, nom, description, prix, prix_promo, meilleur_vente, lien FROM produit WHERE id_produit = :id_produit");
    $stmt->bindParam(':id_produit', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        die("Produit non trouvé.");
    }
} catch (PDOException $e) {
    die("Erreur de requête : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STOCK M</title>
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
                <a href="../index.php"><img src="../image/stockm.jpg.webp" alt="logo STOCKM" id="logo" /></a>
            </div>
            <ul>
                <li><a href="homme.php">Homme</a></li>
                <li><a href="femme.php">Femme</a></li>
                <li><a href="enfant.php">Enfant</a></li>
            </ul>
            <ul>
                <li><a href="panier.php">Panier</a></li>
                <?php
                session_start();
                if (isset($_SESSION['user_email'])) {
                    echo '<li><a href="/Clientleger/php/deconnexion.php">Déconnexion</a></li>';
                } else {
                    echo '<li><a href="/Clientleger/page/connexion.html">Connexion</a></li>';
                }
                ?>
                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?>
                    <li><a href="/Clientleger/page/admin.php">Ajouter un produit</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <!-- Conteneur principal -->
    <div class="main-container">
        <div class="product-container">
            <div class="product-images">
                <img src="<?php echo htmlspecialchars($product['lien']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>" />
            </div>
            <div class="product-details">
                <h1 id="product-name"><?php echo htmlspecialchars($product['nom']); ?></h1>
                <p class="description"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>

                <!-- Prix normal et promo -->
                <?php if (!empty($product['prix_promo']) && $product['prix_promo'] > 0): ?>
                    <p class="price"><s><?php echo number_format($product['prix'], 2, ',', ' '); ?> €</s> <strong><?php echo number_format($product['prix_promo'], 2, ',', ' '); ?> €</strong></p>
                <?php else: ?>
                    <p class="price"><?php echo number_format($product['prix'], 2, ',', ' '); ?> €</p>
                <?php endif; ?>

                <!-- Meilleure vente -->
                <?php if ($product['meilleur_vente'] == 1): ?>
                    <p class="best-seller">⭐ Meilleure Vente ⭐</p>
                <?php endif; ?>

                <!-- Formulaire pour choisir la taille et ajouter au panier -->
                <form action="../php/ajouter_au_panier.php" method="POST">
                    <h3>Choisir une taille :</h3>
                    <div class="sizes">
                        <button type="button" class="size-btn" data-size="EU 36">EU 36</button>
                        <button type="button" class="size-btn" data-size="EU 37">EU 37</button>
                        <button type="button" class="size-btn" data-size="EU 38">EU 38</button>
                        <button type="button" class="size-btn" data-size="EU 39">EU 39</button>
                        <button type="button" class="size-btn" data-size="EU 40">EU 40</button>
                    </div>

                    <!-- Champ caché pour la taille -->
                    <input type="hidden" name="taille" id="selected-size" required>
                    <input type="hidden" name="id_produit" value="<?php echo htmlspecialchars($product['id_produit']); ?>">

                    <div class="actions">
                        <button type="submit">Ajouter au panier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Récupérer tous les boutons de taille
        const sizeButtons = document.querySelectorAll('.size-btn');
        
        // Fonction pour mettre à jour la taille sélectionnée
        sizeButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Mettre la taille choisie dans le champ caché
                const size = button.getAttribute('data-size');
                document.getElementById('selected-size').value = size;
            });
        });
    </script>
</body>
</html>