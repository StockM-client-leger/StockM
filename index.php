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


    <main class="container">
        <section id="presentation">
            <h2>Présentation de StockM</h2>
            <p>StockM est une entreprise spécialisée dans la revente de sneakers rares et recherchées. Basée à Paris, notre mission est de rendre ces modèles d’exception accessibles à tous, partout en France. Nous nous adressons particulièrement aux amateurs de mode streetwear, âgés de 18 à 25 ans, à la recherche de pièces uniques qui reflètent leur style.</p>
            <p>Avec notre site e-commerce, StockM vise à offrir une expérience d'achat fluide et pratique. Plus besoin de se déplacer : nos clients peuvent désormais commander leurs sneakers préférées depuis le confort de leur domicile et profiter de notre service de livraison rapide.</p>
            <ul>
                <li><strong>Exclusivité :</strong> Proposer des modèles rares et en éditions limitées.</li>
                <li><strong>Qualité :</strong> Garantir des produits authentiques et de haute qualité.</li>
                <li><strong>Accessibilité :</strong> Faciliter l'accès à des sneakers emblématiques à travers une interface simple et intuitive.</li>
            </ul>
            <p>Rejoignez StockM et découvrez une collection exclusive de sneakers, soigneusement sélectionnées pour vous.</p>
        </section>
    
        <section id="promotion">
            <h2>Promotions</h2>
            <p>Découvrez nos dernières offres sur les sneakers les plus recherchées !</p>
            <a href="#" class="btn">Voir les promotions</a>
        </section>
    </main>

    <footer>
         2024 StockM. Tous droits réservés à moi.
    </footer>
</body>
</html>