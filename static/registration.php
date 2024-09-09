<?php
// Informations pour se connecter à la base de données
$server = "localhost";
$login = "root";
$password = "";
$db = "ren";

// Récupération des données du formulaire
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$profession = $_POST['profession'];
$passworduser = $_POST['password'];

try {
    // Connexion à la base de données
    $conn = new PDO('mysql:host=' . $server . ';dbname=' . $db, $login, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion à la base de données réussie.<br>";

    // Vérification si le compte existe déjà
    $existingUserQuery = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $existingUserQuery->bindValue(1, $email);
    $existingUserQuery->execute();
    $existingUserResult = $existingUserQuery->fetchAll();

    if (count($existingUserResult) > 0) {
        echo "Un compte avec cette adresse e-mail existe déjà. Procédez à la connexion à votre compte.";
        // Redirection vers la page d'accueil avec le message ci-haut
        header("Location: ../index.html?message=" . urlencode("Un compte avec cette adresse e-mail existe déjà. Procédez à la connexion à votre compte."));
        exit();
    }

    // Préparation de la requête d'insertion
    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, profession, password) VALUES (?, ?, ?, ?, ?)");

    // Vérification de la préparation de la requête
    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    // Liaison des paramètres et exécution de la requête
    $stmt->bindValue(1, $firstname);
    $stmt->bindValue(2, $lastname);
    $stmt->bindValue(3, $email);
    $stmt->bindValue(4, $profession);
    $stmt->bindValue(5, $passworduser);
    $result = $stmt->execute();

    // Vérification de l'exécution de la requête
    if ($result === false) {
        die("Il y a une erreur, réessayez la création de votre compte : " . $stmt->error);
    } else {
        echo "Le compte a été créé avec succès. Maintenant vous pouvez vous connecter à votre compte.";
        // Redirection vers la page d'accueil avec le message 
        header("Location: ../index.html?message=" . urlencode("Le compte a été créé avec succès. Maintenant vous pouvez vous connecter à votre compte."));
        exit();
    }

    // Fermeture de la requête et de la connexion à la base de données
    $stmt->close();
    $conn->close();
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    die();
}
?>

