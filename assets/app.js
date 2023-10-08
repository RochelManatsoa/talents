/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import 'bootstrap';
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

