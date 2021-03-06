$(function () {
    $('.btn-delete').click(function(event){
        //pour ne pas aller directement vers la page de suppression
        event.preventDefault();

        //l'attribut href du bouton supprimer
        var link = $(this).attr('href');

        var $modal = $('#modal_delete');

        //affiche la modale
        $modal.modal('show');

        $modal.find('.btn-confirm-delete').click(function () {
            //redirection vers le lien du bouton supprimer
            window.location.href = link;
        });

        $modal.find('.btn-no-delete').click(function () {
            $('#modal_delete').modal('hide');
        });

    });

});