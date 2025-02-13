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

    <div class="product-grid">
    <a href="chaussure.php">
        <div class="product">
            <img src="https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/gvdaqvcvmvzokrrgrcem/WMNS+AIR+MAX+PLUS.png" alt="Product 1">
            <div class="product-title">Nike Air Max Plus</div>
            <div class="product-description">Chaussure pour homme</div>
            <div class="product-price">189,99 &euro;</div>
        </div>
    </a>

        <a href="chaussure.php">
        <div class="product">
            <img src="https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/6da9b513-93e4-42b3-ad56-c1f52bde4da4/NIKE+AIR+MAX+PLUS.png" alt="Product 2">
            <div class="badge">Meilleure vente</div>
            <div class="product-title">Nike Air Max Plus</div>
            <div class="product-description">Chaussure pour homme</div>
            <div class="product-price">189,99 &euro;</div>
        </div>
    
</a>
        <a href="chaussure.php">
        <div class="product">
            <img src="https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/d21ab10d-19a5-4973-9db0-9231b49955bb/NIKE+AIR+MAX+PLUS+UTILITY.png" alt="Product 3">
            <div class="product-title">Nike Air Max Plus</div>
            <div class="product-description">Chaussure pour homme</div>
            <div class="product-price discount">
                132,99 &euro; <span class="original-price">189,99 &euro;</span>
            </div>
            <div class="discount">30 % de r&eacute;duction</div>
        </div>
    </a>

        <a href="chaussure.php">
        <div class="product">
            <img src="https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/d21ab10d-19a5-4973-9db0-9231b49955bb/NIKE+AIR+MAX+PLUS+UTILITY.png" alt="Product 3">
            <div class="product-title">Nike Air Max Plus</div>
            <div class="product-description">Chaussure pour homme</div>
            <div class="product-price discount">
                132,99 &euro; <span class="original-price">189,99 &euro;</span>
            </div>
            <div class="discount">30 % de r&eacute;duction</div>
        </div>
    </a>

        
    </div>
    

    

</body>
</html>