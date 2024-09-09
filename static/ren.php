<?php
session_start(); // Démarrage de la session après la connexion de l'utilisateur

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!--    Indication de métadonnées : langue du site, librairies et fichiers de style chargés -->
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
          crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>

    <!--    Indication de titre du document -->
    <title>REN</title>
    <link rel="icon" href="../images/REN.ico" type="image/x-icon">
</head>
<body>
<header class="cover-header">
    <div class="header-content">
        <div><img id="logo" src="../images/REN.png" alt="logo 'Reconnaissance d'entités nommées'"></div>
        <div><h2 id="titre">Reconnaissance ou Recherche d'Entités Nommées</h2></div>
    </div>
</header>
<!-- Partie principale du site (menu et contenu) -->
<div class="global">
    <nav>
        <ul id="menu">
            <li class="menu-text"><a href="../index.html#menu">Accueil</a></li>
            <li class="menu-text"><a href="#">Reconnaissance d'entités nommées</a></li>
            <li class="menu-text"><a href="#">Recherche d'entités nommées</a></li>
        </ul>
    </nav>
<div id="main" class="text-center container mb-3">
	<?php
	// Vérification si l'utilisateur est connecté et affichage du lien de déconnection
	if (isset($_SESSION['firstname'])) {
		$firstname = $_SESSION['firstname'];
		echo '<a href="logout.php">Déconnexion</a>';
	} else {
		// Redirection vers la page d'accueil si l'utilisateur n'est pas connecté
		header("Location: ../index.html");
		exit();
	}
	?>
    <div id="user">
        <!-- Affichage d'informations de l'utilisateur de la session -->
        <div class="border p-3">
		    <h3 class="text-success">Bienvenue, <?php echo $firstname; ?> !</h3>
		</div>
    </div>
    <br/>
    <!-- Formulaires prenant en input un fichier ou un texte -->
	<form method="POST" action="resultat.php" enctype="multipart/form-data">
        <label class="form-label" for="langue">Choisissez une des 3 langues proposées :</label>
    <select name="langue" id="langue">   
        <option value="en">Anglais</option>
		<option value="fr">Français</option>
        <option value="uk">Ukrainien</option>
    </select>
    <br/>        
        <label class="form-label" for="texte">Insérez le texte à analyser :</label>
		<br>
        <textarea name="texte" id="texte" rows="5" cols="75"></textarea>
        <br>
        <label class="form-label" for="fichier">Choisissez un fichier à analyser :</label>
		<br>
        <input type="file" name="fichier" id="fichier">
        <br><br>     
        <input type="submit" value="Analyser" class="btn btn-success">
    </form>	
		</div>
	</div>
</div>
<!-- Pied du site (footer) -->
<footer>
    <div class="footer-container">
        <div class="footer">

            <h2><img id="footer-logo" src="../images/REN.ico" alt="logo REN" style="height: 40px; width: 40px"> REN
            </h2>
        </div>
        <span id="credits">Site créé par Yuliya Masalskaya <br>
            © Tous droits réservés</span>
        <div class="footer-links">
            <a href="../index.html#menu">Accueil</a>
        </div>
    </div>
</footer>
</body>
</html>








