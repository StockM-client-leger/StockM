<?php
session_start();
require_once '../php/db.php';

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user_email']) || !isset($_SESSION['id_utilisateur'])) {
    header("Location: connexion2.php");
    exit();
}

// Récupération des informations de l'utilisateur
$query = "SELECT * FROM utilisateur WHERE id_utilisateur = :id";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $_SESSION['id_utilisateur']]);
$user = $stmt->fetch();

// Récupération des commandes de l'utilisateur
$query = "SELECT p.*, GROUP_CONCAT(m.nom) as produits
          FROM panier p 
          LEFT JOIN commande c ON p.id_panier = c.id_panier
          LEFT JOIN modele m ON c.id_modele = m.id_modele
          WHERE p.id_utilisateur = :id_utilisateur AND p.valide = 1
          GROUP BY p.id_panier
          ORDER BY p.date_validation DESC";
$stmt = $pdo->prepare($query);
$stmt->execute(['id_utilisateur' => $_SESSION['id_utilisateur']]);
$commandes = $stmt->fetchAll();
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
    <title>Mon Profil - STOCK M</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Header existant -->
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
            </ul>
        </nav>
    </header>

    <div class="profile-container">
        <div class="profile-section">
            <h1>Mon Profil</h1>
            <div class="profile-info">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert success">
                        <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                        ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert error">
                        <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                        ?>
                    </div>
                <?php endif; ?>
                <h2>Informations personnelles</h2>
                <form action="../php/modifier_profil.php" method="POST" class="profile-form">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nouveau_mdp">Nouveau mot de passe (optionnel)</label>
                        <input type="password" id="nouveau_mdp" name="nouveau_mdp" minlength="6">
                    </div>
                    <button type="submit" class="btn-update">Mettre à jour</button>
                </form>
            </div>
        </div>

        <div class="orders-section">
            <h2>Mes commandes</h2>
            <?php if (empty($commandes)): ?>
                <p>Vous n'avez pas encore de commandes.</p>
            <?php else: ?>
                <div class="orders-list">
                    <?php foreach ($commandes as $commande): ?>
                        <div class="order-item">
                            <div class="order-header">
                                <span class="order-date">
                                    Commande du <?= date('d/m/Y', strtotime($commande['date_validation'])) ?>
                                </span>
                            </div>
                            <div class="order-details">
                                <p><strong>Produits:</strong> <?= htmlspecialchars($commande['produits']) ?></p>
                                <p><strong>Adresse:</strong> <?= htmlspecialchars($commande['adresse_livraison']) ?></p>
                                <p><strong>Ville:</strong> <?= htmlspecialchars($commande['ville']) ?></p>
                                <p><strong>Code Postal:</strong> <?= htmlspecialchars($commande['code_postal']) ?></p>
                                <p><strong>Mode de livraison:</strong> <?= htmlspecialchars($commande['mode_livraison']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>