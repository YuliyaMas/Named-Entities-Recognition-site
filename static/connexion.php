<?php
session_start(); // Démarrage de la session

// Informations de connexion à la base de données
$server = "localhost";
$login = "root";
$password = "";
$db = "ren";

// Récupération du mail et mot de pass de l'utilisateur de la bdd
$email = $_POST['email'];
$passworduser = $_POST['password'];

try {
    // Connexion à la base de données
    $conn = new PDO('mysql:host=' . $server . ';dbname=' . $db, $login, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL pour vérifier si l'email et le mot de passe existent dans la base de données
    $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $email);
    $stmt->bindValue(2, $passworduser);
    $stmt->execute();
    $result = $stmt->fetchAll();

    // Vérification des erreurs lors de l'exécution de la requête SQL
    if (!$result) {
        die("Erreur lors de l'exécution de la requête : " . $stmt->errorInfo()[2]);
    }

    if (count($result) > 0) {
        // Si l'utilisateur existe, on ouvre une session et définit la variable de session
        $_SESSION['firstname'] = $result[0]['firstname']; 
        header("Location: ren.php"); // Redirection vers la page de reconnaissance d'entités nommées
        exit();
    } else {
        // Si l'utilisateur n'existe pas ou les informations de connexion sont incorrectes, on affiche un message sur la page d'accueil
        echo "L'adresse mail ou le mot de passe est incorrect. Veuillez réessayer la connexion ou créer un nouveau compte.";
        // Redirection vers la page d'accueil avec le message 
        header("Location: ../index.html?message=" . urlencode("L'adresse mail ou le mot de passe est incorrect. Veuillez réessayer la connexion ou créer un nouveau compte."));
        exit();
    }
    // Fermeture de la requête et de la connexion à la base de données
    $stmt->closeCursor();
    $conn = null;
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
