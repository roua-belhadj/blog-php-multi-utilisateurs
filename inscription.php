<?php
require 'config.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // On crypte le mot de passe !

    try {
        // Préparation de la requête pour éviter les injections SQL
        $sql = "INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $email, $password]);
        $message = "<p style='color:green;'>Compte créé avec succès ! <a href='connexion.php'>Connectez-vous ici</a></p>";
    } catch (PDOException $e) {
        $message = "<p style='color:red;'>Erreur : Cet email est peut-être déjà utilisé.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - MyBlog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="card" style="max-width: 400px; margin: auto;">
            <h2>Créer un compte</h2>
            <?= $message ?>
            <form method="POST">
                <div style="margin-bottom: 15px;">
                    <label>Nom complet</label><br>
                    <input type="text" name="nom" required style="width:100%; padding:8px; border-radius:5px; border:1px solid #ccc;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label>Email</label><br>
                    <input type="email" name="email" required style="width:100%; padding:8px; border-radius:5px; border:1px solid #ccc;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label>Mot de passe</label><br>
                    <input type="password" name="password" required style="width:100%; padding:8px; border-radius:5px; border:1px solid #ccc;">
                </div>
                <button type="submit" class="btn" style="width: 100%;">S'inscrire</button>
            </form>
            <p style="margin-top:15px; font-size:0.9rem;">Déjà inscrit ? <a href="connexion.php">Se connecter</a></p>
        </div>
    </div>
</body>
</html>