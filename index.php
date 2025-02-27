

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STOCK M</title>
    <link rel="stylesheet" href="./style/style.css">
    <script src="script/script.js" defer></script>
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
                <img src="image/stockm.jpg.webp" alt="logo STOCKM" id="logo"/>
            </div>

            <ul>
                <li><a href="page/homme.php">Homme</a></li>
                <li><a href="page/femme.php">Femme</a></li>
                <li><a href="page/enfant.php">Enfant</a></li>
            </ul>
            
            <ul>
                <li><a href="page/panier.php">Panier</a></li>
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

