<?php
session_start();
require_once '../php/db.php';

// Debug
error_log("Session existante: " . print_r($_SESSION, true));

// Redirection si non connecté
if (!isset($_SESSION['user_email']) || !isset($_SESSION['id_utilisateur'])) {
    header("Location: /Clientleger/page/connexion2.php?redirect=" . urlencode($_SERVER['REQUEST_URI']));
    exit();
}

try {
    $query = "SELECT m.nom, m.prix, m.prix_promo, m.lien, c.id_taille, p.id_panier 
              FROM panier p 
              INNER JOIN commande c ON p.id_panier = c.id_panier 
              INNER JOIN modele m ON c.id_modele = m.id_modele 
              WHERE p.id_utilisateur = :id_utilisateur
              ORDER BY p.dateh_panier DESC";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id_utilisateur' => $_SESSION['id_utilisateur']]);
    $produits_panier = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Debug
    error_log("ID utilisateur: " . $_SESSION['id_utilisateur']);
    error_log("Nombre de produits trouvés: " . count($produits_panier));
    
} catch (PDOException $e) {
    error_log("Erreur SQL: " . $e->getMessage());
    die("Une erreur est survenue lors de la récupération du panier.");
}
?>
<?php
// Ajouter au début de chaque fichier, juste après session_start()
function isCurrentPage($page) {
    return strpos($_SERVER['PHP_SELF'], $page) !== false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

    <div class="cart-container">
        <?php if (empty($produits_panier)): ?>
            <p>Votre panier est vide.</p>
        <?php else: ?>
            <?php 
            $total = 0;
            foreach ($produits_panier as $produit): 
                // Calcul du prix (promo ou normal)
                $prix = ($produit['prix_promo'] > 0) ? $produit['prix_promo'] : $produit['prix'];
                $total += $prix;
            ?>
                <div class="product-item">
                    <img src="<?php echo htmlspecialchars($produit['lien']); ?>" alt="<?php echo htmlspecialchars($produit['nom']); ?>" />
                    <div class="product-details">
                        <h2><?php echo htmlspecialchars($produit['nom']); ?></h2>
                        <p>Prix : <?php echo number_format($produit['prix'], 2, ',', ' ') . " €"; ?></p>
                        <?php if ($produit['prix_promo'] > 0): ?>
                            <p>Prix promo : <?php echo number_format($produit['prix_promo'], 2, ',', ' ') . " €"; ?></p>
                        <?php endif; ?>
                        <p>Taille : <?php echo htmlspecialchars($produit['id_taille']); ?></p>
                    </div>
                    <form action="../php/supprimer_du_panier.php" method="POST">
                        <input type="hidden" name="id_panier" value="<?php echo $produit['id_panier']; ?>">
                        <button type="submit">Supprimer</button>
                    </form>
                </div>
            <?php endforeach; ?>

            <div class="cart-summary">
                <h3>Récapitulatif de votre panier</h3>
                <p class="total">Total : <?php echo number_format($total, 2, ',', ' '); ?> €</p>
                <form action="commande.php" method="POST" class="checkout-form">
                    <input type="hidden" name="total" value="<?php echo $total; ?>">
                    <button type="submit" class="btn-commander">Passer la commande</button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <footer class="footer">
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> STOCK M - Tous droits réservés</p>
        </div>
    </footer>

    <style>
    .cart-summary {
        margin-top: 20px;
        padding: 20px;
        background-color: #f8f8f8;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .total {
        font-size: 1.2em;
        font-weight: bold;
        color: #ecd90c;
        text-align: right;
        margin: 10px 0;
    }

    .btn-commander {
        background-color: #ecd90c;
        color: #2d2b2b;
        padding: 12px 24px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1.1em;
        width: 100%;
        transition: background-color 0.3s ease;
    }

    .btn-commander:hover {
        background-color: #d4c30b;
    }

    .product-item {
        margin-bottom: 15px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .product-details {
        flex: 1;
    }

    .product-item img {
        width: 100px;
        height: auto;
        border-radius: 4px;
    }
    </style>

</body>
</html>