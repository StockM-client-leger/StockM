<?php
session_start();
require_once '../php/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link rel="stylesheet" href="../style/style.css">
    <script src="../script/script.js" defer></script>
</head>
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
<body>

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

    <div class="cart-container">
        <?php
        if (!isset($_SESSION['id_utilisateur'])) {
            die("Vous devez être connecté pour voir votre panier.");
        }

        $query = "SELECT p.nom, p.prix, p.prix_promo, p.lien, c.taille, c.id_panier FROM panier c 
                  INNER JOIN produit p ON c.id_produit = p.id_produit 
                  WHERE c.id_utilisateur = :id_utilisateur";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_utilisateur', $_SESSION['id_utilisateur'], PDO::PARAM_INT);
        $stmt->execute();

        $produits_panier = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($produits_panier):
            foreach ($produits_panier as $produit):
        ?>
            <div class="product-item">
                <img src="<?php echo htmlspecialchars($produit['lien']); ?>" alt="<?php echo htmlspecialchars($produit['nom']); ?>" />
                <div class="product-details">
                    <h2><?php echo htmlspecialchars($produit['nom']); ?></h2>
                    <p>Prix : <?php echo number_format($produit['prix'], 2, ',', ' ') . " €"; ?></p>
                    <?php if ($produit['prix_promo'] > 0): ?>
                        <p>Prix promo : <?php echo number_format($produit['prix_promo'], 2, ',', ' ') . " €"; ?></p>
                    <?php endif; ?>
                    <p>Taille : <?php echo htmlspecialchars($produit['taille']); ?></p>
                </div>
                <form action="../php/supprimer_du_panier.php" method="POST">
                    <input type="hidden" name="id_panier" value="<?php echo $produit['id_panier']; ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </div>
        <?php
            endforeach;
        else:
            echo "Votre panier est vide.";
        endif;
        ?>
    </div>

</body>
</html>