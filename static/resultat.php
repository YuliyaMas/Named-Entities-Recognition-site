<?php
// Démarrage de la session
session_start();

// Récupération du prénom de l'utilisateur depuis la session
$firstname = isset($_SESSION['firstname']) ? $_SESSION['firstname'] : '';

// Vérification si l'utilisateur est connecté
if (empty($firstname)) {
    // Sinon redirection vers la page de connexion
    header("Location: ../index.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération de la langue choisie
    $langue = $_POST["langue"];
    
    // Récupération du texte à analyser
    $texte = $_POST["texte"];
    
    // Vérification si un fichier a été téléchargé
    if (isset($_FILES["fichier"]) && $_FILES["fichier"]["error"] == UPLOAD_ERR_OK) {
        // Récupérer le contenu du fichier
        $fichier_contenu = file_get_contents($_FILES["fichier"]["tmp_name"]);
        $texte = $fichier_contenu;
    }
    
    // Échappement les guillemets doubles dans le texte ce qui permet de récuperer le mot sans guillemets pour reconnaissance
    $texte = addslashes($texte);
    
    // Appel au script Python pour l'analyse des entités nommées
    // $command = "python ren_3lang.py $langue \"$texte\"";
	$command = escapeshellcmd("C:/Users/yuliy/AppData/Local/Programs/Python/Python312/python.exe ren_3lang.py") . ' ' . escapeshellarg($langue) . ' ' . escapeshellarg($texte) . ' 2>&1';
	$resultat = shell_exec($command);
	
	if (!$resultat) {
		error_log("Échec de l'exécution du script Python : $resultat");
		echo "Une erreur est survenue lors de l'exécution du script Python";
	} 
	//else {
	//	echo "Résultat : " . $resultat; // Affiche la sortie du script Python pour le débogage
	//}


    
    // Convertissement du résultat JSON (sortie du code Python) en tableau PHP
    $resultat_array = json_decode($resultat, true);
	
	// Sauvegarde des entités nommées dans la base de données
    if ($resultat_array !== null) {
        // Informations pour se connecter à la base de données
        $server = "localhost";
        $login = "root";
        $password = "";
        $db = "ren";
        
        try {
            // Connexion à la base de données
            $conn = new PDO('mysql:host=' . $server . ';dbname=' . $db, $login, $password);
            
            // Vérification de la connexion
            if (!$conn) {
                throw new Exception("Erreur de connexion à la base de données.");
            }
        
            // Préparation de la requête d'insertion
			$stmt = $conn->prepare("INSERT INTO entities (entity, label) VALUES (:entity, :label)");

			// Parcours des entités et leur insertion dans la base de données
			foreach ($resultat_array['entites'] as $entite) {
				$entity = $entite['entite'];
				$label = $entite['label'];

				// Liaison des paramètres et exécution de la requête
				$stmt->bindParam(':entity', $entity);
				$stmt->bindParam(':label', $label);
				$result = $stmt->execute();

				// Vérification de l'exécution de la requête
				if ($result === false) {
					throw new Exception("Erreur lors de l'insertion de l'entité : " . $stmt->errorInfo()[2]);
				}
			}

            // echo "Les entités ont été ajoutées avec succès dans la base de données.";
        
            // Fermeture de la requête et de la connexion à la base de données
            $stmt->closeCursor();
            $conn = null;
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!--    Indication de métadonnées -->
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
<!--  Menu -->
<div class="global">
    <nav>
        <ul id="menu">
            <li class="menu-text"><a href="../index.html#menu">Accueil</a></li>
            <li class="menu-text"><a href="ren.php">Reconnaissance d'entités nommées</a></li>
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
            <div class="border p-3">
                <h3 class="text-success">Bienvenue, <span id="firstname"><?php echo $firstname; ?></span> !</h3>
            </div>
        </div>
        <br/>
		<!--  Affichage du résultat de reconnaissance d'EN -->
        <h3>Résultat de l'analyse :</h3>
        <div id="result" class="mt-3 d-flex align-items-center justify-content-center">
           <?php
			// Vérification si la conversion en tableau est réussie
			if ($resultat_array !== null) {
				// Affichage des résultats dans un tableau HTML avec bordures
				echo '<table style="border-collapse: collapse; border: 1px solid black;">';
				echo '<thead><tr><th style="border: 1px solid black; width: 200px;">Entité</th><th style="border: 1px solid black; width: 200px;">Label</th></tr></thead>';
				echo '<tbody>';
				foreach ($resultat_array['entites'] as $entite) {
					echo '<tr>';
					echo '<td style="border: 1px solid black;">' . htmlspecialchars($entite['entite']) . '</td>';
					echo '<td style="border: 1px solid black;">' . htmlspecialchars($entite['label']) . '</td>';
					echo '</tr>';
				}
				echo '</tbody>';
				echo '</table>';
			} else {
				echo "Aucun résultat à afficher.";
			}
			?>
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
