<?php
// Démarrer la session
session_start();
unset($_SESSION);
// Détruire toutes les données de session
session_destroy();

// Rediriger vers la page de connexion
header("Location: ../login/login.php");
exit;
?>