<?php
session_start(); // Toujours mettre session_start() en tout premier

require 'db.php'; // Inclure le fichier de connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $email = $_POST['email'];
    $password = $_POST['mot_de_passe'];

    // Modification de la requête pour utiliser id_utilisateur au lieu de id
    $sql = "SELECT id_utilisateur, email, mot_de_passe FROM utilisateur WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['mot_de_passe'])) {
        // Stocker l'email et l'ID de l'utilisateur dans la session
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['id_utilisateur'] = $user['id_utilisateur']; // Modification ici aussi
        // Définir is_admin en fonction de l'email
        $_SESSION['is_admin'] = ($user['email'] === 'Admin@gmail.com');

        // Debug
        error_log("Session ID utilisateur: " . $_SESSION['id_utilisateur']);

        // Redirection avec le paramètre redirect
        $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '/Clientleger/index.php';
        header("Location: " . $redirect);
        exit();
    } else {
        // Rediriger avec un message d'erreur
        header("Location: /Clientleger/page/connexion2.php?error=1");
        exit();
    }
}
?>