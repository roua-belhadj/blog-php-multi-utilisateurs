<?php
// Paramètres de connexion
$host = 'localhost';
$dbname = 'blog_db'; // Le nom que tu as donné dans phpMyAdmin
$user = 'root';      // Utilisateur par défaut de XAMPP
$pass = '';          // Mot de passe vide par défaut sur XAMPP

try {
    // On crée la connexion
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    
    // On demande à PHP d'afficher les erreurs s'il y en a
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si la connexion échoue, on affiche l'erreur
    die("Erreur de connexion : " . $e->getMessage());
}
?>
