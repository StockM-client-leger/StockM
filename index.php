<?php
session_start();
require 'php/db.php'; // Connexion à la base de données

// Vérifier si la connexion à la base de données est bien établie
if (!$pdo) {
    die("Erreur de connexion à la base de données.");
}

// Récupération de tous les produits
$sql = "SELECT id_modele, nom, lien, prix, prix_promo FROM modele ORDER BY id_modele DESC";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                    <li><a href="/Clientleger/page/connexion2.php">Connexion</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?>
                    <li><a href="/Clientleger/page/admin.php">Ajouter un produit</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <h1 class="carousel-title"><span>Nos chaussures disponibles !</span></h1>
    
    <div class="carousel-container">
        <div class="carousel">
            <?php foreach ($produits as $index => $produit): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <a href="page/chaussure.php?id_modele=<?= htmlspecialchars($produit['id_modele']) ?>">
                        <img src="<?= htmlspecialchars($produit['lien']) ?>" 
                             alt="<?= htmlspecialchars($produit['nom']) ?>">
                        <div class="carousel-info">
                            <h3><?= htmlspecialchars($produit['nom']) ?></h3>
                            <div class="carousel-price">
                                <?php if (!empty($produit['prix_promo'])): ?>
                                    <span class="original-price"><?= number_format($produit['prix'], 2) ?> €</span>
                                    <span class="promo-price"><?= number_format($produit['prix_promo'], 2) ?> €</span>
                                <?php else: ?>
                                    <?= number_format($produit['prix'], 2) ?> €
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="carousel-controls">
            <button class="carousel-control" id="prevBtn">
                <i class="fas fa-chevron-circle-left"></i>
            </button>
            <button class="carousel-control" id="nextBtn">
                <i class="fas fa-chevron-circle-right"></i>
            </button>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = document.querySelector('.carousel');
        const items = document.querySelectorAll('.carousel-item');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        let currentIndex = 0;
        const itemWidth = items[0].offsetWidth + 30; // Width + margin
        const visibleItems = 3;

        function updateCarousel() {
            const newTransform = -currentIndex * itemWidth;
            carousel.style.transform = `translateX(${newTransform}px)`;

            // Update active class
            items.forEach(item => item.classList.remove('active'));
            items[currentIndex].classList.add('active');
        }

        nextBtn.addEventListener('click', () => {
            if (currentIndex < items.length - visibleItems) {
                currentIndex++;
                updateCarousel();
            }
        });

        prevBtn.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
                updateCarousel();
            }
        });

        // Auto scroll
        setInterval(() => {
            if (currentIndex < items.length - visibleItems) {
                currentIndex++;
            } else {
                currentIndex = 0;
            }
            updateCarousel();
        }, 5000);
    });
    </script>

    <footer class="footer">
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> STOCK M - Tous droits réservés</p>
        </div>
    </footer>

</body>
</html>