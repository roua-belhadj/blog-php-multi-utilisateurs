<?php
session_start();
require 'config.php';
if (!isset($_SESSION['user_id'])) { header("Location: connexion.php"); exit(); }

$stmt = $pdo->prepare("SELECT * FROM articles WHERE id_user = ? ORDER BY date_publication DESC");
$stmt->execute([$_SESSION['user_id']]);
$mes_articles = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard - <?= $_SESSION['user_nom'] ?></title>
</head>
<body>
    <header>
        <a href="index.php" class="logo">BLOG.io</a>
        <nav>
            <a href="index.php" style="margin-right:20px; text-decoration:none; color:gray;">Voir le site</a>
            <a href="deconnexion.php" style="color:red; text-decoration:none;">Déconnexion</a>
        </nav>
    </header>

    <div class="container">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:40px;">
            <h1>Bienvenue, <?= $_SESSION['user_nom'] ?> 👋</h1>
            <a href="ajouter_article.php" class="btn">+ Nouvel Article</a>
        </div>

        <div class="grid">
            <?php foreach($mes_articles as $a): ?>
                <div class="card">
                    <div class="card-body">
                        <h3><?= htmlspecialchars($a['titre']) ?></h3>
                        <p style="color:gray; font-size:0.8rem;">Publié le <?= $a['date_publication'] ?></p>
                        <hr style="margin:15px 0; border:0; border-top:1px solid #eee;">
                        <a href="article.php?id=<?= $a['id_article'] ?>" style="color:var(--primary); text-decoration:none;">Voir</a>
                        <a href="supprimer_article.php?id=<?= $a['id_article'] ?>" style="color:red; margin-left:15px; text-decoration:none;" onclick="return confirm('Supprimer ?')">Supprimer</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>