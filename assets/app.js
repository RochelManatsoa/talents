/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import 'bootstrap';
import './bootstrap.js';
import 'bootstrap-icons/font/bootstrap-icons.css';
import $ from 'jquery';

$(function() {
    // Vérifiez si vous êtes sur la page d'accueil
    // if ($('#homepage-indicator').length > 0) {
    //     var prevScrollpos = $(window).scrollTop();

    //     $(window).on('scroll', function() {
    //         var currentScrollPos = document.documentElement.scrollTop || document.body.scrollTop;

    //         if (currentScrollPos === 0) {
    //             $('#navbar').removeClass('show');
    //         } else {
    //             $('#navbar').addClass('show');
    //         }

    //         prevScrollpos = currentScrollPos;
    //     });
    // }else{
    //     $('#navbar').addClass('show');
    // }
    $('#account_identity .custom-control-input').on('change', function() {
        $(this).closest('form').submit();
    });

    $('.image-checkbox img').on('click', function() {
        // Ajouter l'effet de clignotement
        $(this).addClass('blinking');
        
        // Retirer l'effet de clignotement après 1.2 secondes (2 cycles d'animation)
        setTimeout(() => {
            $(this).removeClass('blinking');
        }, 900);
    });

    $('#previewButton').on('click', function(e) {
        e.preventDefault();
        // Récupérer les données du formulaire
        const formData = {
            title: $('input[name="posting[title]"]').val(),
            description: $('textarea[name="posting[description]"]').val(),
            tarif: $('input[name="posting[tarif]"]').val(),
            number: $('input[name="posting[number]"]').val(),
            plannedDate: $('input[name="posting[plannedDate]"]').val()
        };
        const typeText = $('select[name="posting[type]"] option:selected').text();
        const sectorText = $('select[name="posting[sector]"] option:selected').text();

        console.log(formData)
        const content = `
            <p><span class="text-strong">Titre :</span> <br>${formData.title}</p>
            <p><span class="text-strong">Type :</span> <br>${typeText}</p>
            <p><span class="text-strong">Secteur d'activité :</span> <br>${sectorText}</p>
            <p><span class="text-strong">Description du poste:</span> <br>${formData.description}</p>
            <p><span class="text-strong">Budget :</span> <br>${formData.tarif} €</p>
            <p><span class="text-strong">Date du début :</span> <br>${formData.plannedDate} </p>
            <!-- Et ainsi de suite pour les autres champs... -->
        `;
        $('#previewModal .modal-body').html(content);
    
    });
    

});

const elements = $('.js-remove');
console.log(elements);

elements.each(function() {
    $(this).on("click", function(event) {
        event.preventDefault();

        // Demander confirmation
        const userConfirmed = window.confirm("Êtes-vous sûr de vouloir supprimer cet élément ?");
        
        if (userConfirmed) {
            const url = $(this).attr('data-href');
            const $clickedLink = $(this);

            $.post(url, function(response) {
                // Supprimer le grand-parent de l'élément clickedLink du DOM
                $clickedLink.parent().parent().remove();
            });
        } else {
            // L'utilisateur a annulé l'action
            console.log("Action annulée par l'utilisateur.");
        }
    });
});