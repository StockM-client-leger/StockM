<?php
session_start();
require_once 'db.php';

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user_email']) || !isset($_SESSION['id_utilisateur'])) {
    header("Location: ../page/connexion2.php");
    exit();
}

// Vérification que le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $nouveau_mdp = isset($_POST['nouveau_mdp']) ? trim($_POST['nouveau_mdp']) : '';
        
        // Début de la requête de mise à jour
        $sql = "UPDATE utilisateur SET email = :email";
        $params = ['email' => $email, 'id' => $_SESSION['id_utilisateur']];
        
        // Si un nouveau mot de passe est fourni
        if (!empty($nouveau_mdp)) {
            $hash = password_hash($nouveau_mdp, PASSWORD_DEFAULT);
            $sql .= ", mot_de_passe = :mot_de_passe";
            $params['mot_de_passe'] = $hash;
        }
        
        $sql .= " WHERE id_utilisateur = :id";
        
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute($params);
        
        if ($result) {
            // Mise à jour de l'email dans la session
            $_SESSION['user_email'] = $email;
            $_SESSION['success'] = "Profil mis à jour avec succès";
        } else {
            $_SESSION['error'] = "Erreur lors de la mise à jour du profil";
        }
        
    } catch (PDOException $e) {
        $_SESSION['error'] = "Une erreur est survenue";
        error_log("Erreur de mise à jour du profil : " . $e->getMessage());
    }
    
    // Redirection vers la page profil
    header("Location: ../page/profil.php");
    exit();
} else {
    // Si accès direct au fichier sans POST
    header("Location: ../page/profil.php");
    exit();
}
?>