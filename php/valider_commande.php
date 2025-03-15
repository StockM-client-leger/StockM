<?php
session_start();
require_once 'db.php';

// Vérification de la connexion
if (!isset($_SESSION['user_email']) || !isset($_SESSION['id_utilisateur'])) {
    header("Location: ../page/connexion2.php");
    exit();
}

// Vérification des données POST
if (!isset($_POST['adresse']) || !isset($_POST['code_postal']) || !isset($_POST['ville']) || !isset($_POST['livraison'])) {
    $_SESSION['error'] = "Tous les champs sont requis";
    header("Location: ../page/panier.php");
    exit();
}

try {
    $pdo->beginTransaction();

    // Mise à jour du panier avec les informations de livraison
    $query = "UPDATE panier SET 
        valide = 1,
        adresse_livraison = :adresse,
        code_postal = :code_postal,
        ville = :ville,
        mode_livraison = :mode_livraison,
        date_validation = NOW()
        WHERE id_utilisateur = :id_utilisateur 
        AND valide = 0";

    $stmt = $pdo->prepare($query);
    $result = $stmt->execute([
        'adresse' => $_POST['adresse'],
        'code_postal' => $_POST['code_postal'],
        'ville' => $_POST['ville'],
        'mode_livraison' => $_POST['livraison'],
        'id_utilisateur' => $_SESSION['id_utilisateur']
    ]);

    if ($result) {
        $pdo->commit();
        // Créer une page de confirmation
        header("Location: ../page/confirmation_commande.php");
    } else {
        throw new Exception("Erreur lors de la validation de la commande");
    }

} catch (Exception $e) {
    $pdo->rollBack();
    error_log("Erreur validation commande : " . $e->getMessage());
    $_SESSION['error'] = "Une erreur est survenue lors de la validation de votre commande";
    header("Location: ../page/panier.php");
}
?>