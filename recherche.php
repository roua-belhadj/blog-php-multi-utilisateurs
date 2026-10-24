<?php 
session_start();
require 'config.php';
$q = isset($_GET['q']) ? $_GET['q'] : '';
$stmt = $pdo->prepare("SELECT articles.*, utilisateurs.nom FROM articles JOIN utilisateurs ON articles.id_user = utilisateurs.id_user WHERE titre LIKE ?");
$stmt->execute(["%$q%"]);
$articles = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Recherche</title>
</head>
<body>
    <header><a href="index.php" class="logo">BLOG.io</a></header>
    <div class="container">
        <h2>Résultats pour "<?= htmlspecialchars($q) ?>"</h2>
        <div class="grid-articles" style="margin-top:20px;">
            <?php foreach($articles as $a): ?>
                <div class="card">
                    <img src="https://picsum.photos/seed/<?= $a['id_article'] ?>/400/250" class="card-img">
                    <div class="card-body">
                        <h4><?= htmlspecialchars($a['titre']) ?></h4>
                        <a href="article.php?id=<?= $a['id_article'] ?>" class="btn" style="margin-top:10px;">Voir</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>