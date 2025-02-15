<?php
session_start(); // Démarre la session

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_email'])) {
    die("Vous devez être connecté pour ajouter un produit au panier.");
}

// Vérifie si l'ID de l'utilisateur est bien dans la session
if (!isset($_SESSION['id_utilisateur'])) {
    die("Vous devez être connecté pour ajouter un produit au panier.");
}

// Affiche le contenu de la session pour vérifier
var_dump($_SESSION); // Vérifie le contenu de la session

include('db.php'); // Assure-toi que la connexion à la base de données est incluse

// Récupère l'ID du produit, la taille et l'ID de l'utilisateur
$id_produit = $_POST['id_produit'];
$id_utilisateur = $_SESSION['id_utilisateur']; 
$taille = $_POST['taille'];

// Prépare la requête SQL pour insérer dans le panier
$query = "INSERT INTO panier (id_utilisateur, id_produit, taille) VALUES (:id_utilisateur, :id_produit, :taille)";
$stmt = $pdo->prepare($query);

// Lier les paramètres
$stmt->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
$stmt->bindParam(':id_produit', $id_produit, PDO::PARAM_INT);
$stmt->bindParam(':taille', $taille, PDO::PARAM_STR);

// Exécuter la requête
if ($stmt->execute()) {
    echo "Produit ajouté au panier avec succès. vous allez être redirigé au panier.";
    header("Refresh: 2; url=/Clientleger/page/panier.php");
} else {
    echo "Erreur lors de l'ajout au panier.";
}

// Fermer la requête
$stmt = null;
$pdo = null; // Fermer également la connexion PDO
?>