<?php
session_start();
include('../php/db.php');

// Vérifier si l'utilisateur est un admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: /Clientleger/index.php");
    exit();
}
    
// Ajouter un produit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajouter_produit'])) {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $genre = $_POST['genre'];
    $lien = $_POST['lien'];
    $prix_promo = isset($_POST['prix_promo']) && $_POST['prix_promo'] !== "" ? $_POST['prix_promo'] : NULL;
    $meilleur_vente = isset($_POST['meilleur_vente']) && $_POST['meilleur_vente'] !== "" ? $_POST['meilleur_vente'] : 0;

    // Vérification des champs
    if (empty($nom) || empty($description) || empty($prix) || empty($genre) || empty($lien)) {
        echo "Tous les champs doivent être remplis.";
    } else {
        // Requête d'insertion dans la base de données
        $sql = "INSERT INTO produit (nom, description, prix, genre, lien, prix_promo, meilleur_vente) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$nom, $description, $prix, $genre, $lien, $prix_promo, $meilleur_vente])) {
            echo "Produit ajouté avec succès !";
            // Rediriger vers la page d'administration après l'ajout
            header("Location: ../page/admin.php");
            exit();
        } else {
            echo "Erreur lors de l'ajout du produit.";
        }
    }
} else {
    echo "Aucune donnée reçue.";
}
?>