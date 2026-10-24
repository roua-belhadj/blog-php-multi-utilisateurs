<?php
session_start(); // Très important pour gérer la connexion
require 'config.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // On vérifie si l'utilisateur existe et si le mot de passe est correct
    if ($user && password_verify($password, $user['mot_de_passe'])) {
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['user_nom'] = $user['nom'];
        header("Location: dashboard.php"); // On le redirige vers son espace
        exit();
    } else {
        $error = "Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - MyBlog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="card" style="max-width: 400px; margin: auto;">
            <h2>Connexion</h2>
            <?php if($error): ?>
                <p style="color:red;"><?= $error ?></p>
            <?php endif; ?>
            <form method="POST">
                <div style="margin-bottom: 15px;">
                    <label>Email</label><br>
                    <input type="email" name="email" required style="width:100%; padding:8px; border-radius:5px; border:1px solid #ccc;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label>Mot de passe</label><br>
                    <input type="password" name="password" required style="width:100%; padding:8px; border-radius:5px; border:1px solid #ccc;">
                </div>
                <button type="submit" class="btn" style="width: 100%;">Se connecter</button>
            </form>
            <p style="margin-top:15px; font-size:0.9rem;">Pas encore de compte ? <a href="inscription.php">S'inscrire</a></p>
        </div>
    </div>
</body>
</html>
