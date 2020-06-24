$('#envoi').click(function(e){
    e.preventDefault(); // on empêche le bouton d'envoyer le formulaire

    var pseudo = 'camille' // on sécurise les données
    var message = encodeURIComponent( $('#message').val() );

    if(message != ""){ // on vérifie que les variables ne sont pas vides
        $.ajax({
            url : "/chat/traitement", // on donne l'URL du fichier de traitement
            type : "post", // la requête est de type POST
            data : {
                message: message
            }, // et on envoie nos données
            success: function (data) {
                $('#messages').append("<p>" + message + "</p>"); // on ajoute le message dans la zone prévue
            },
            error: function () {
                alert('Erreur !');
            }
        });


    }
});

function charger(){

    setTimeout( function(){
        // on lance une requête AJAX
        $.ajax({
            url : "/chat/traitement",
            type : GET,
            success : function(html){
                $('#messages').prepend(html); // on veut ajouter les nouveaux messages au début du bloc #messages
            }
        });

        charger(); // on relance la fonction

    }, 5000); // on exécute le chargement toutes les 5 secondes

}

charger();

