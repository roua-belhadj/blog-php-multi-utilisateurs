<?php
session_start();
require 'config.php';

// Sécurité : si pas connecté, on renvoie à la connexion
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];
    $id_user = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO articles (id_user, titre, contenu) VALUES (?, ?, ?)");
    $stmt->execute([$id_user, $titre, $contenu]);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Publier un article</title>
</head>
<body>
    <header>
        <a href="index.php" class="logo">BLOG.io</a>
        <a href="index.php" style="text-decoration:none; color:var(--dark);">Annuler</a>
    </header>

    <div class="container" style="max-width: 700px;">
        <div style="background:white; padding:40px; border-radius:20px; box-shadow:0 10px 25px rgba(0,0,0,0.05);">
            <h2 style="color:var(--primary); margin-bottom:20px;">Nouvel Article ✨</h2>
            <form method="POST">
                <label style="display:block; margin-bottom:10px; font-weight:bold;">Titre de l'article</label>
                <input type="text" name="titre" placeholder="Ex: L'impact de l'IA..." required>

                <label style="display:block; margin-bottom:10px; font-weight:bold;">Contenu</label>
                <textarea name="contenu" placeholder="Écrivez votre texte ici..." style="height:300px;" required></textarea>

                <button type="submit" class="btn" style="width:100%; padding:15px;">Publier sur le blog</button>
            </form>
        </div>
    </div>
</body>
</html>