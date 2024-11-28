<?php
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
        echo "Connexion réussie!";
        // Rediriger vers une page protégée après la connexion
        header("Location: ./page/index.html");
        exit();
    } else {
        echo "Email ou mot de passe incorrect.";
    }
}
?>