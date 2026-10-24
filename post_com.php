<?php
session_start();
require 'config.php';

if(isset($_SESSION['user_id']) && isset($_POST['contenu']) && isset($_POST['id_article'])) {
    $id_art = $_POST['id_article'];
    $id_usr = $_SESSION['user_id'];
    $texte = $_POST['contenu'];

    $stmt = $pdo->prepare("INSERT INTO commentaires (id_article, id_user, contenu) VALUES (?, ?, ?)");
    $stmt->execute([$id_art, $id_usr, $texte]);
}

header("Location: article.php?id=" . $_POST['id_article']);
exit();
?>