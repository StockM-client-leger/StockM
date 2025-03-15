<?php
session_start();
require_once '../php/db.php'; // Assure-toi que ce chemin est correct

// Vérifie si l'ID est bien passé dans l'URL
if (isset($_GET['id_modele'])) {
    $product_id = intval($_GET['id_modele']); // Convertit en entier pour éviter les erreurs
    $origine = isset($_GET['origine']) ? $_GET['origine'] : 'homme';
} else {
    die("ID du produit manquant."); // Arrête l'exécution et affiche un message d'erreur
}

// Connexion à la base de données avec PDO
try {
    $stmt = $pdo->prepare("SELECT id_modele, nom, description, prix, prix_promo, meilleur_vente, lien FROM modele WHERE id_modele = :id_modele");
    $stmt->bindParam(':id_modele', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        die("Produit non trouvé.");
    }
    
    // Récupérer les tailles disponibles pour ce modèle
    $stmt_tailles = $pdo->prepare("
        SELECT DISTINCT p.id_taille 
        FROM produit p 
        WHERE p.id_modele = :id_modele 
        ORDER BY p.id_taille ASC
    ");
    $stmt_tailles->execute(['id_modele' => $product_id]);
    $tailles = $stmt_tailles->fetchAll(PDO::FETCH_COLUMN);
    
    // Si aucune taille n'est disponible, utiliser des tailles par défaut
    if (empty($tailles)) {
        $tailles_par_defaut = [
            'homme' => ['40', '41', '42', '43', '44', '45'],
            'femme' => ['36', '37', '38', '39', '40'],
            'enfant' => ['28', '29', '30', '31', '32', '33', '34', '35']
        ];
        $tailles = $tailles_par_defaut[$origine] ?? $tailles_par_defaut['homme'];
    }

} catch (PDOException $e) {
    die("Erreur de requête : " . $e->getMessage());
}
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
                <form action="../php/ajouter_au_panier.php" method="POST" id="addToCartForm">
                    <h3>Choisir une taille :</h3>
                    <div class="sizes">
                        <?php if (!empty($tailles)): ?>
                            <?php foreach ($tailles as $taille): ?>
                                <button type="button" class="size-btn" data-size="<?php echo htmlspecialchars($taille); ?>">
                                    <?php echo htmlspecialchars($taille); ?>
                                </button>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Aucune taille disponible</p>
                        <?php endif; ?>
                    </div>

                    <!-- Champ caché pour la taille -->
                    <input type="hidden" name="taille" id="selected-size" required>
                    <input type="hidden" name="id_modele" value="<?php echo htmlspecialchars($product['id_modele']); ?>">

                    <div class="actions">
                        <button type="submit" onclick="return handleAddToCart(event)">
                            Ajouter au panier
                        </button>
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
                // Retirer la classe active de tous les boutons
                sizeButtons.forEach(btn => btn.classList.remove('active'));
                // Ajouter la classe active au bouton cliqué
                button.classList.add('active');
                // Mettre la taille choisie dans le champ caché
                const size = button.getAttribute('data-size');
                document.getElementById('selected-size').value = size;
            });
        });

        function checkLogin(event) {
            event.preventDefault();
            if (!document.getElementById('selected-size').value) {
                alert('Veuillez sélectionner une taille');
                return false;
            }
            
            window.location.href = '/Clientleger/page/connexion2.php?redirect=' + encodeURIComponent(window.location.href);
            return false;
        }

        function handleAddToCart(event) {
            event.preventDefault();
            console.log('handleAddToCart appelé'); // Debug
            
            if (!document.getElementById('selected-size').value) {
                alert('Veuillez sélectionner une taille');
                return false;
            }
            
            <?php if (!isset($_SESSION['user_email'])): ?>
                if (confirm('Vous devez être connecté pour ajouter au panier. Voulez-vous vous connecter ?')) {
                    window.location.href = '/Clientleger/page/connexion2.php?redirect=' + encodeURIComponent(window.location.href);
                }
                return false;
            <?php else: ?>
                const form = document.getElementById('addToCartForm');
                const formData = new FormData(form);
                
                // Debug des données envoyées
                for (let pair of formData.entries()) {
                    console.log(pair[0] + ': ' + pair[1]);
                }
                
                fetch('../php/ajouter_au_panier.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Réponse reçue:', data); // Debug
                    if (data.error) {
                        alert('Erreur : ' + data.message);
                    } else {
                        window.location.href = '/Clientleger/page/panier.php';
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue lors de l\'ajout au panier');
                });
                return false;
            <?php endif; ?>
        }
    </script>
    <footer class="footer">
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> STOCK M - Tous droits réservés</p>
        </div>
    </footer>

    <style>
        .size-btn.active {
            background-color: #ecd90c;
            color: #2d2b2b;
        }
    </style>
</body>
</html>