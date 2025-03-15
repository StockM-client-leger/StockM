<?php
session_start();
include('db.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ajout d'un header HTML pour une meilleure présentation
echo '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ajout de produit</title>
    <style>
        .error-message, .success-message, .debug-message {
            padding: 15px;
            margin: 10px;
            border-radius: 4px;
        }
        .error-message {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ef9a9a;
        }
        .success-message {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
        }
        .debug-message {
            background-color: #e3f2fd;
            color: #1565c0;
            border: 1px solid #90caf9;
        }
    </style>
</head>
<body>';

// Fonction pour afficher les messages avec débogage
function displayMessage($message, $type = 'error') {
    // Afficher les données POST pour le débogage
    if ($type === 'error') {
        echo "<div class='debug-message'>Données reçues : <pre>" . print_r($_POST, true) . "</pre></div>";
    }
    echo "<div class='{$type}-message'>{$message}</div>";
    echo "<script>
        setTimeout(function() {
            window.location.href = '/Clientleger/page/admin.php';
        }, 5000);
    </script>";
}

// Vérifier si l'utilisateur est un admin
if (!isset($_SESSION['user_email']) || $_SESSION['user_email'] !== 'Admin@gmail.com') {
    displayMessage("Accès non autorisé");
    exit();
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['ajouter_produit'])) {
        displayMessage("Erreur : Le formulaire n'a pas été soumis correctement");
        exit();
    }

    try {
        // Débuter une transaction
        $pdo->beginTransaction();

        // Récupération et validation des données
        $nom = trim($_POST['nom'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $prix = floatval($_POST['prix'] ?? 0);
        $genre = $_POST['genre'] ?? '';
        $lien = trim($_POST['lien'] ?? '');
        $prix_promo = !empty($_POST['prix_promo']) ? floatval($_POST['prix_promo']) : null;
        $meilleur_vente = isset($_POST['meilleur_vente']) ? 1 : 0;

        // Validation des données avec messages détaillés
        $errors = [];
        if (empty($nom)) $errors[] = "Le nom est requis";
        if (empty($description)) $errors[] = "La description est requise";
        if ($prix <= 0) $errors[] = "Le prix doit être supérieur à 0";
        if (empty($genre)) $errors[] = "Le genre est requis";
        if (empty($lien)) $errors[] = "Le lien de l'image est requis";
        if (empty($_POST['tailles']) || !is_array($_POST['tailles'])) {
            $errors[] = "Au moins une taille doit être sélectionnée";
        }

        if (!empty($errors)) {
            throw new Exception("Erreurs de validation :<br>" . implode("<br>", $errors));
        }

        // Insertion du modèle
        $sql = "INSERT INTO modele (nom, description, prix, genre, lien, prix_promo, meilleur_vente) 
                VALUES (:nom, :description, :prix, :genre, :lien, :prix_promo, :meilleur_vente)";
        
        $stmt = $pdo->prepare($sql);
        $params = [
            ':nom' => $nom,
            ':description' => $description,
            ':prix' => $prix,
            ':genre' => $genre,
            ':lien' => $lien,
            ':prix_promo' => $prix_promo,
            ':meilleur_vente' => $meilleur_vente
        ];
        
        error_log("Tentative d'insertion du modèle avec les paramètres : " . print_r($params, true));
        
        if (!$stmt->execute($params)) {
            throw new Exception("Erreur lors de l'insertion du modèle: " . implode(", ", $stmt->errorInfo()));
        }

        $id_modele = $pdo->lastInsertId();
        error_log("Modèle inséré avec l'ID : " . $id_modele);

        // Insertion des tailles
        $sql_taille = "INSERT INTO produit (id_modele, id_taille) VALUES (:id_modele, :id_taille)";
        $stmt_taille = $pdo->prepare($sql_taille);
        
        foreach ($_POST['tailles'] as $taille) {
            if (!$stmt_taille->execute([':id_modele' => $id_modele, ':id_taille' => $taille])) {
                throw new Exception("Erreur lors de l'ajout de la taille " . $taille);
            }
            error_log("Taille " . $taille . " ajoutée");
        }

        // Validation de la transaction
        $pdo->commit();
        error_log("Transaction validée avec succès");
        
        displayMessage("Produit ajouté avec succès !", 'success');
        $_SESSION['success_message'] = "Produit ajouté avec succès !";
        exit();

    } catch (Exception $e) {
        $pdo->rollBack();
        error_log("Erreur lors de l'ajout du produit : " . $e->getMessage());
        displayMessage("Erreur : " . $e->getMessage());
        $_SESSION['error_message'] = "Erreur : " . $e->getMessage();
        exit();
    }
} else {
    displayMessage("Méthode non autorisée. Utilisez POST.");
    exit();
}

echo '</body></html>';
?>