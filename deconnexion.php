<?php
session_start();
session_destroy(); // On efface la session
header("Location: index.php"); // On retourne à l'accueil
exit();
?>