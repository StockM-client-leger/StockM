<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Debug des données reçues
error_log("POST data: " . print_r($_POST, true));
error_log("SESSION data: " . print_r($_SESSION, true));

// Vérification de la connexion
if (!isset($_SESSION['user_email']) || !isset($_SESSION['id_utilisateur'])) {
    error_log("Erreur: Utilisateur non connecté");
    header('Content-Type: application/json');
    echo json_encode([
        'error' => true,
        'message' => 'Vous devez être connecté pour ajouter au panier',
        'redirect' => '/Clientleger/page/connexion2.php?redirect=' . urlencode($_SERVER['HTTP_REFERER'])
    ]);
    exit;
}

include('db.php');

try {
    $pdo->beginTransaction();
    
    // Vérification des données POST
    if (!isset($_POST['id_modele']) || !isset($_POST['taille'])) {
        throw new Exception("Données du produit manquantes");
    }
    
    // Debug des valeurs
    error_log("ID Modèle: " . $_POST['id_modele']);
    error_log("Taille: " . $_POST['taille']);
    error_log("ID Utilisateur: " . $_SESSION['id_utilisateur']);
    
    // Créer un nouveau panier
    $query = "INSERT INTO panier (dateh_panier, id_utilisateur) VALUES (NOW(), :id_utilisateur)";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id_utilisateur' => $_SESSION['id_utilisateur']]);
    $id_panier = $pdo->lastInsertId();
    error_log("Nouveau panier créé avec ID: " . $id_panier);

    // Ajouter le produit à la commande
    $query = "INSERT INTO commande (id_panier, id_modele, id_taille, qte) 
              VALUES (:id_panier, :id_modele, :id_taille, 1)";
    $stmt = $pdo->prepare($query);
    $result = $stmt->execute([
        'id_panier' => $id_panier,
        'id_modele' => $_POST['id_modele'],
        'id_taille' => $_POST['taille']
    ]);

    if ($result) {
        $pdo->commit();
        error_log("Produit ajouté avec succès");
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'message' => 'Produit ajouté au panier',
            'redirect' => '/Clientleger/page/panier.php'
        ]);
    } else {
        throw new Exception("Erreur lors de l'ajout au panier: " . implode(", ", $stmt->errorInfo()));
    }
} catch (Exception $e) {
    error_log("Erreur dans ajouter_au_panier.php: " . $e->getMessage());
    $pdo->rollBack();
    header('Content-Type: application/json');
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
}
?>