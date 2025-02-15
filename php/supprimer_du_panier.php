<?php
session_start(); // Démarre la session

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_email'])) {
    die("Vous devez être connecté pour supprimer un produit du panier.");
}

// Vérifie si l'ID de l'utilisateur est bien dans la session
if (!isset($_SESSION['id_utilisateur'])) {
    die("Vous devez être connecté pour supprimer un produit du panier.");
}

// Vérifie si l'ID du panier est bien reçu via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_panier'])) {
    $id_panier = $_POST['id_panier']; // Récupère l'ID du panier à supprimer

    include('db.php'); // Connexion à la base de données

    // Prépare la requête SQL pour supprimer l'article du panier
    $query = "DELETE FROM panier WHERE id_panier = :id_panier AND id_utilisateur = :id_utilisateur";
    $stmt = $pdo->prepare($query);

    // Lier les paramètres
    $stmt->bindParam(':id_panier', $id_panier, PDO::PARAM_INT);
    $stmt->bindParam(':id_utilisateur', $_SESSION['id_utilisateur'], PDO::PARAM_INT);

    // Exécuter la requête
    if ($stmt->execute()) {
        header("Location: ../page/panier.php"); // Redirige directement vers le panier
        exit;
    } else {
        echo "Erreur lors de la suppression du produit.";
    }

    // Fermer la requête et la connexion
    $stmt = null;
    $pdo = null;
} else {
    echo "Aucun produit spécifié pour la suppression.";
}
?>