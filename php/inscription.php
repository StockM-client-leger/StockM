<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

    $sql_check = "SELECT * FROM utilisateur WHERE email = ?";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute([$email]);

    if ($stmt_check->rowCount() > 0) {
        echo "L'email est déjà utilisé.";
        header("Refresh: 0; url=/Clientleger/page/inscription.html");
    } else {
        $sql = "INSERT INTO utilisateur (Nom, Prenom, email, mot_de_passe) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        try {
            if ($stmt->execute([$nom, $prenom, $email, $mot_de_passe])) {
                echo "Inscription réussie!";
                header("Refresh: 0; url=/Clientleger/page/connexion.html");
                exit();
            }
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
    }
}
?>