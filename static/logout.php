<?php
session_start();  // Démarrage de la session après la connexion de l'utilisateur
session_destroy();  // Déconnection de la session 
header("Location: ../index.html"); // Redirection vers la page d'accueil après la déconnexion
exit;
?>
