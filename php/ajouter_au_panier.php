<?php
session_start();

if (!isset($_SESSION['user_email']) || !isset($_SESSION['id_utilisateur'])) {
    die("Vous devez être connecté pour ajouter un produit au panier.");
}

include('db.php');

try {
    // Créer un nouveau panier si nécessaire
    $query = "INSERT INTO panier (dateh_panier, id_utilisateur) VALUES (NOW(), :id_utilisateur)";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id_utilisateur' => $_SESSION['id_utilisateur']]);
    $id_panier = $pdo->lastInsertId();

    // Ajouter le produit à la commande
    $query = "INSERT INTO commande (id_panier, id_modele, id_taille, qte) 
              VALUES (:id_panier, :id_modele, :id_taille, 1)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'id_panier' => $id_panier,
        'id_modele' => $_POST['id_modele'],
        'id_taille' => $_POST['taille']
    ]);

    echo "Produit ajouté au panier avec succès.";
    header("Refresh: 0; url=/Clientleger/page/panier.php");
} catch (PDOException $e) {
    echo "Erreur lors de l'ajout au panier: " . $e->getMessage();
}
?>