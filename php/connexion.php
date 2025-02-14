<?php
session_start(); // Toujours mettre session_start() en tout premier

include('db.php'); // Inclure le fichier de connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Requête pour récupérer l'utilisateur avec l'email donné
    $sql = "SELECT * FROM utilisateur WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $utilisateur = $stmt->fetch();

    if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
        // Stocker l'email dans la session
        $_SESSION['user_email'] = $email;

        // Vérifier si l'email est "Admin@gmail.com"
        if ($_SESSION['user_email'] === 'Admin@gmail.com') {
            $_SESSION['is_admin'] = true; // Si l'email est Admin@gmail.com, on définit un flag
        } else {
            $_SESSION['is_admin'] = false; // Sinon, on définit le flag comme false
        }

        // Afficher le message avant la redirection
        echo "Connexion réussie ! Vous allez être redirigé...";
        header("Refresh: 3; url=/Clientleger/index.php");
        exit();
    } else {
        echo "Email ou mot de passe incorrect. Redirection en cours...";
        header("Refresh: 3; url=/Clientleger/page/connexion.html");
        exit();
    }
}
?>