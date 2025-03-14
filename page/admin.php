<?php
session_start();
include('../php/db.php');

// Vérifier si l'utilisateur est un admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: /Clientleger/index.php");
    exit();
}

// Suppression d'un produit
if (isset($_GET['supprimer'])) {
    $id_modele = $_GET['supprimer'];

    // Requête de suppression du produit
    $sql = "DELETE FROM modele WHERE id_modele = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$id_modele])) {
        echo "Produit supprimé avec succès !";
    } else {
        echo "Erreur lors de la suppression du produit.";
    }
}

// Récupérer la liste des produits
$sql = "SELECT * FROM modele";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$produits = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STOCK M</title>
    <link rel="stylesheet" href="../style/style.css">
    <script src="../script/script.js" defer></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector("form");
        const fields = form.querySelectorAll("input[required], textarea[required]");

        fields.forEach(field => {
            let errorMessage = document.createElement("span");
            errorMessage.classList.add("error-message");
            errorMessage.innerText = "Ce champ est obligatoire";
            errorMessage.style.display = "block";
            errorMessage.style.color = "red";
            errorMessage.style.fontSize = "0.9em";
            field.parentNode.appendChild(errorMessage);

            field.addEventListener("input", function () {
                if (field.value.trim() !== "") {
                    errorMessage.style.display = "none";
                } else {
                    errorMessage.style.display = "block";
                }
            });
        });

        form.addEventListener("submit", function (event) {
            let isValid = true;
            fields.forEach(field => {
                if (field.value.trim() === "") {
                    isValid = false;
                    field.nextElementSibling.style.display = "block";
                }
            });
            if (!isValid) {
                event.preventDefault();
            }
        });
    });
    </script>
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

    <!-- Formulaire pour ajouter un produit -->
    <main class="container">
        <section>
            <div id="ajouter-produit-form">
                <h2>Ajouter un Produit</h2>
                <form action="../php/ajouter_produit.php" method="post">
                    <div class="form-group">
                        <label for="nom">Nom :</label>
                        <input type="text" id="nom" name="nom" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description :</label>
                        <textarea id="description" name="description" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="prix">Prix :</label>
                        <input type="number" id="prix" name="prix" step="0.01" required>
                    </div>

                    <div class="form-group">
                        <label for="genre">Genre :</label>
                        <select id="genre" name="genre" required>
                            <option value="Homme">Homme</option>
                            <option value="Femme">Femme</option>
                            <option value="Enfant">Enfant</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="lien">Lien de l'image :</label>
                        <input type="url" id="lien" name="lien" required>
                    </div>

                    <div class="form-group">
                        <label for="prix_promo">Prix promo :</label>
                        <input type="number" id="prix_promo" name="prix_promo" step="0.01">
                    </div>

                    <div class="form-group">
                        <label for="meilleur_vente">Meilleur vente :</label>
                        <input type="number" id="meilleur_vente" name="meilleur_vente" placeholder="0 ou 1" required>
                    </div>

                    <div class="form-group">
                        <label>Tailles disponibles :</label>
                        <div class="sizes-checkboxes">
                            <?php for($i = 28; $i <= 46; $i++): ?>
                                <div class="size-checkbox">
                                    <input type="checkbox" id="taille_<?= $i ?>" name="tailles[]" value="<?= $i ?>">
                                    <label for="taille_<?= $i ?>"><?= $i ?></label>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <button type="submit" name="ajouter_produit" class="btn">Ajouter</button>
                </form>
            </div>
        </section>
    </main>
    <hr>

    <!-- Liste des produits existants -->
    <main class="container">
        <div id="produits-list">
            <h2>Liste des produits</h2>
            <table>
                <tr>
                    <th>Id Produit</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Genre</th>
                    <th>Lien</th>
                    <th>Prix promo</th>
                    <th>Meilleur vente</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($produits as $produit): ?>
                    <tr>
                        <td><?= htmlspecialchars($produit['id_modele']) ?></td>
                        <td><?= htmlspecialchars($produit['nom']) ?></td>
                        <td><?= htmlspecialchars($produit['description']) ?></td>
                        <td><?= htmlspecialchars($produit['prix']) ?> €</td>
                        <td><?= htmlspecialchars($produit['genre']) ?></td>
                        <td><a href="<?= htmlspecialchars($produit['lien']) ?>">Voir</a></td>
                        <td><?= htmlspecialchars($produit['prix_promo']) ?></td>
                        <td><?= htmlspecialchars($produit['meilleur_vente']) ?></td>
                        <td>
                            <!-- Lien pour supprimer le produit -->
                            <a href="admin.php?supprimer=<?= $produit['id_modele'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </main>
</body>
</html>