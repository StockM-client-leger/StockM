<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STOCK M</title>
    <link rel="stylesheet" href="../style/style.css">
    <script src="../script/script.js" defer></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .cart-container {
            max-width: 800px;
            margin: auto;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .cart-item img {
            width: 100px;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .cart-details {
            flex: 2;
            margin-left: 10px;
        }

        .cart-details h3 {
            margin: 0;
            font-size: 18px;
        }

        .cart-details p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }

        .cart-actions {
            text-align: right;
        }

        .cart-actions button {
            padding: 5px 10px;
            border: none;
            background-color: #000;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }

        .cart-actions button:hover {
            background-color: #444;
        }
    </style>
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
                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?>
                    <li><a href="/Clientleger/page/admin.php">Ajouter un produit</a></li>
                <?php endif; ?>
        </ul>
    </nav>
</header>
    <p>Le site e-commerce de sneakers</p>

    <div class="cart-container"></div>

</body>
</html>