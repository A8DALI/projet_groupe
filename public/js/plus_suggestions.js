$(document).ready(function () {

    var offset = 3;

    $("#load").click(function () {
        // Nombre de ligne à ajouter dans la requete dans UserRepository
        $.ajax({
            type: 'get',
            // new twig in suggestions
            // created with a function in SuggestionController
            url: '/suggestions/plus',
            data: {
                getresult: offset
            },

            success: function (response) {
                if (response == 'erreur') {
                    $('#plus').replaceWith('<p>Pas de résultats!</p>');
                } else {

                var content = document.getElementById("cartes_row");
                content.innerHTML = content.innerHTML + response;
                }
            }
        });

        offset += 3;
    });
})


