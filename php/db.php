<?php
$host = 'localhost'; // ou l'adresse de votre serveur MySQL
$username = 'root'; // votre nom d'utilisateur MySQL
$password = ''; // votre mot de passe MySQL
$dbname = 'stockm'; // nom de la base de données

try {
    // Connexion avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}
?>