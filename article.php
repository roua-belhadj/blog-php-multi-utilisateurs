<?php
session_start();
require 'config.php';

if(!isset($_GET['id'])) { header("Location: index.php"); exit(); }
$id_article = $_GET['id'];

// Article
$stmt = $pdo->prepare("SELECT articles.*, utilisateurs.nom FROM articles JOIN utilisateurs ON articles.id_user = utilisateurs.id_user WHERE id_article = ?");
$stmt->execute([$id_article]);
$article = $stmt->fetch();

// Like
if(isset($_POST['like']) && isset($_SESSION['user_id'])) {
    $check = $pdo->prepare("SELECT * FROM likes WHERE id_article = ? AND id_user = ?");
    $check->execute([$id_article, $_SESSION['user_id']]);
    if($check->rowCount() == 0) {
        $ins = $pdo->prepare("INSERT INTO likes (id_article, id_user) VALUES (?, ?)");
        $ins->execute([$id_article, $_SESSION['user_id']]);
    }
}

// Stats Likes
$stmt_l = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE id_article = ?");
$stmt_l->execute([$id_article]);
$total_likes = $stmt_l->fetchColumn();

// Commentaires
$stmt_c = $pdo->prepare("SELECT commentaires.*, utilisateurs.nom FROM commentaires JOIN utilisateurs ON commentaires.id_user = utilisateurs.id_user WHERE id_article = ? ORDER BY date_commentaire DESC");
$stmt_c->execute([$id_article]);
$commentaires = $stmt_c->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title><?= $article['titre'] ?></title>
</head>
<body>
    <header>
        <a href="index.php" class="logo">BLOG.io</a>
        <a href="index.php" style="text-decoration:none; color:var(--dark);">← Retour</a>
    </header>

    <div class="container" style="max-width:800px;">
        <h1 style="color:var(--primary); font-size:2.5rem; margin-bottom:20px;"><?= htmlspecialchars($article['titre']) ?></h1>
        
        <div style="background:white; padding:30px; border-radius:20px; box-shadow:0 5px 15px rgba(0,0,0,0.05);">
            <div style="display:flex; align-items:center; margin-bottom:20px;">
                <div class="avatar"><?= strtoupper(substr($article['nom'], 0, 1)) ?></div>
                <strong>Publié par <?= $article['nom'] ?></strong>
            </div>
            
            <p style="font-size:1.1rem; line-height:1.8;"><?= nl2br(htmlspecialchars($article['contenu'])) ?></p>
            
            <form method="POST" style="margin-top:30px; border-top:1px solid #eee; padding-top:20px;">
                <button type="submit" name="like" style="background:#fee2e2; border:none; padding:10px 20px; border-radius:12px; cursor:pointer; font-weight:bold; color:#ef4444;">
                    ❤️ <?= $total_likes ?> Likes
                </button>
            </form>
        </div>

        <div style="margin-top:40px;">
            <h3>Avis des lecteurs 💬</h3>
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <form action="post_com.php" method="POST" style="margin-top:20px;">
                    <input type="hidden" name="id_article" value="<?= $id_article ?>">
                    <textarea name="contenu" placeholder="Votre avis..." style="width:100%; padding:15px; border-radius:10px; border:1px solid #ddd; height:100px;" required></textarea>
                    <button type="submit" class="btn" style="margin-top:10px;">Poster mon avis</button>
                </form>
            <?php endif; ?>

            <?php foreach($commentaires as $c): ?>
                <div style="background:white; padding:15px; border-radius:12px; margin-top:15px; border-left:5px solid var(--primary);">
                    <small><strong><?= htmlspecialchars($c['nom']) ?></strong></small>
                    <p style="margin-top:5px;"><?= htmlspecialchars($c['contenu']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>