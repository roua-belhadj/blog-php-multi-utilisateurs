<?php
session_start();
require 'config.php';

if(isset($_GET['id']) && isset($_SESSION['user_id'])){
    $stmt = $pdo->prepare("DELETE FROM articles WHERE id_article = ? AND id_user = ?");
    $stmt->execute([$_GET['id'], $_SESSION['user_id']]);
}
header("Location: dashboard.php");
?>