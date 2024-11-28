<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include('db.php'); // Inclure le fichier de connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Sécurisation du mot de passe
    $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    // Vérifier si l'email existe déjà dans la base de données
    $sql_check = "SELECT * FROM utilisateur WHERE email = ?";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute([$email]);

    if ($stmt_check->rowCount() > 0) {
        echo "L'email est déjà utilisé. Veuillez en choisir un autre.";
    } else {
        // Insertion dans la table utilisateur
        $sql = "INSERT INTO utilisateur (nom, prenom, email, mot_de_passe) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        try {
            // Exécution de la requête
            if ($stmt->execute([$nom, $prenom, $email, $mot_de_passe_hache])) {
                // Afficher un message d'inscription réussie avant la redirection
                echo "Inscription réussie!";
                // Redirection vers la page de connexion après un court délai
                header("Refresh: 5; url=./page/connexion.html"); // Attendre 2 secondes avant la redirection
                exit();
            } else {
                echo "Erreur lors de l'exécution de la requête : " . implode(", ", $stmt->errorInfo());
            }
        } catch (PDOException $e) {
            echo "Erreur lors de l'inscription: " . $e->getMessage();
        }
    }
}
?>