<?php 
session_start();
require 'config.php';

// Statistiques
$count_art = $pdo->query("SELECT COUNT(*) FROM articles")->fetchColumn();
$count_users = $pdo->query("SELECT COUNT(*) FROM utilisateurs")->fetchColumn();

// Articles
$stmt = $pdo->query("SELECT articles.*, utilisateurs.nom FROM articles 
                    JOIN utilisateurs ON articles.id_user = utilisateurs.id_user 
                    ORDER BY date_publication DESC");
$articles = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>BLOG.io - Accueil</title>
</head>
<body>
    <header>
        <div style="display:flex; align-items:center; gap:30px;">
            <a href="index.php" class="logo">BLOG.io</a>
            <form action="recherche.php" method="GET" class="search-bar">
                <input type="text" name="q" placeholder="Rechercher...">
            </form>
        </div>

        <div style="display:flex; align-items:center;">
            <span class="stats-badge">📈 <?= $count_art ?> Articles</span>
            <span class="stats-badge" style="background:#10b981;">👥 <?= $count_users ?> Membres</span>
            <div style="margin-left:20px;">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="dashboard.php" class="btn-outline">Mon Profil</a>
                    <a href="deconnexion.php" style="margin-left:15px; color:red; text-decoration:none;">Quitter</a>
                <?php else: ?>
                    <a href="connexion.php" style="text-decoration:none; color:var(--dark); margin-right:15px;">Connexion</a>
                    <a href="inscription.php" class="btn">Rejoindre</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <div class="container">
        <h2 style="margin-bottom:25px; color:var(--primary);">Explorer les articles</h2>
        <div class="grid-articles">
            <?php foreach($articles as $a): ?>
                <div class="card">
                    <img src="https://picsum.photos/seed/<?= $a['id_article'] ?>/400/250" class="card-img">
                    <div class="card-body">
                        <h4 style="margin-bottom:10px;"><?= htmlspecialchars($a['titre']) ?></h4>
                        <div style="display:flex; align-items:center; margin-bottom:15px;">
                            <div class="avatar" style="width:25px; height:25px; font-size:0.7rem;"><?= strtoupper(substr($a['nom'], 0, 1)) ?></div>
                            <span style="font-size:0.8rem;"><?= $a['nom'] ?></span>
                        </div>
                        <a href="article.php?id=<?= $a['id_article'] ?>" class="btn" style="width:100%; text-align:center;">Lire l'article</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>