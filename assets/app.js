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
    if ($('#homepage-indicator').length > 0) {
        var prevScrollpos = $(window).scrollTop();

        $(window).on('scroll', function() {
            var currentScrollPos = document.documentElement.scrollTop || document.body.scrollTop;

            if (currentScrollPos === 0) {
                $('#navbar').removeClass('show');
            } else {
                $('#navbar').addClass('show');
            }

            prevScrollpos = currentScrollPos;
        });
    }else{
        $('#navbar').addClass('show');
    }

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