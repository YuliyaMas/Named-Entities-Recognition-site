$(document).ready(function() {
    // Permet de cacher les formulaires d'inscription et de connection au moment du lancement du site
    $('#register-form').hide();
    $('#login-form').hide();


    // Permet de gérer le clic sur le lien "Connexion" (on altèrne l'affichage des formulaires Connection et Inscription)
    $('.link-login').click(function(e) {
        e.preventDefault();
        $('#login-form').show();
        $('#register-form').hide();
    });

    // Permet de gérer le clic sur le lien "Inscription"
    $('.link-register').click(function(e) {
        e.preventDefault();
        $('#login-form').hide();
        $('#register-form').show();
    });
});





