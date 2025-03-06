<?php
session_start();
require 'php/db.php'; // Connexion à la base de données

// Vérifier si la connexion à la base de données est bien établie
if (!$pdo) {
    die("Erreur de connexion à la base de données.");
}

// Récupération de plusieurs produits (ex: 6 derniers produits ajoutés)
$sql = "SELECT id_produit, nom, lien FROM produit ORDER BY id_produit DESC LIMIT 6";
$stmt = $pdo->query($sql);
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STOCK M</title>
    <link rel="stylesheet" href="./style/style.css">
    <script src="script/script.js" defer></script>
    <style>
        .content-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 20px;
            padding: 20px;
        }

        .text-box {
            font-size: 1.5em;
            font-weight: bold;
            color: #ffcc00;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 10px;
            border-radius: 10px;
        }

        .image-box img {
            width: 230px;
            height: 300;
            border-radius: 10px;
            transition: transform 0.3s;
        }

        .image-box img:hover {
            transform: scale(1.1);
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="logo-container">
                <img src="image/stockm.jpg.webp" alt="logo STOCKM" id="logo" />
            </div>
            <ul>
                <li><a href="page/homme.php">Homme</a></li>
                <li><a href="page/femme.php">Femme</a></li>
                <li><a href="page/enfant.php">Enfant</a></li>
            </ul>
            <ul>
                <li><a href="page/panier.php">Panier</a></li>
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

    <section class="content-container">
        <div class="text-box">Découvrez les meilleures sneakers du moment !</div>
        <?php if (!empty($produits)): ?>
            <?php foreach ($produits as $produit): ?>
                <div class="image-box">
                    <a href="page/chaussure.php?id_produit=<?= htmlspecialchars($produit['id_produit']) ?>">
                        <img src="<?= htmlspecialchars($produit['lien']) ?>" alt="<?= htmlspecialchars($produit['nom']) ?>">
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun produit disponible.</p>
        <?php endif; ?>
        <div class="text-box" style="color: #00ffcc; font-size: 2em;">Nouvelles collections disponibles !</div>
    </section>
</body>

</html>