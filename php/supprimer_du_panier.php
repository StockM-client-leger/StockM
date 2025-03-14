<?php
session_start();

if (!isset($_SESSION['user_email']) || !isset($_SESSION['id_utilisateur'])) {
    die("Vous devez être connecté pour supprimer un produit du panier.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_panier'])) {
    include('db.php');

    try {
        $query = "DELETE FROM commande WHERE id_panier = :id_panier";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id_panier' => $_POST['id_panier']]);

        // Supprimer également le panier
        $query = "DELETE FROM panier WHERE id_panier = :id_panier AND id_utilisateur = :id_utilisateur";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'id_panier' => $_POST['id_panier'],
            'id_utilisateur' => $_SESSION['id_utilisateur']
        ]);

        header("Location: ../page/panier.php");
        exit;
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression: " . $e->getMessage();
    }
} else {
    echo "Aucun produit spécifié pour la suppression.";
}
?>