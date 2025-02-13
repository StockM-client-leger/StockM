<!DOCTYPE html>
<html lang="en">
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
            <a href="../index.php"><img src="../image/stockm.jpg.webp" alt="logo STOCKM" id="logo"/></a>
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
        </ul>
    </nav>
</header>
    <p>Le site e-commerce de sneakers</p>

    <div class="product-container">
        <div class="product-images">
            <img src="/path/to/shoe1.jpg" alt="Chaussure vue principale" class="shoe-image" id="shoe-image-1" data-name="Nike Air Max Plus" data-price="199,99 €" onclick="changeShoe(this)">
            <img src="/path/to/shoe2.jpg" alt="Chaussure vue latérale" class="shoe-image" id="shoe-image-2" data-name="Nike Dunk Low" data-price="149,99 €" onclick="changeShoe(this)">
            <img src="/path/to/shoe3.jpg" alt="Chaussure vue arrière" class="shoe-image" id="shoe-image-3" data-name="Nike Air Force One" data-price="129,99 €" onclick="changeShoe(this)">
        </div>
        <div class="product-details">
            <h1 id="product-name">Nike Air Max Plus</h1>
            <p class="price" id="product-price">199,99 €</p>
            <div class="sizes">
                <h3>Choisir une taille :</h3>
                <button>EU 36</button>
                <button>EU 37</button>
                <button>EU 38</button>
                <button>EU 39</button>
                <button>EU 40</button>
            </div>
            <div class="actions">
                <button>Ajouter au panier</button>
                <button class="favorites">Ajouter aux favoris</button>
            </div>
        </div>
    </div>
    
</body>
</html>