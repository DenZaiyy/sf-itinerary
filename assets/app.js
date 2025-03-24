import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

const alert = document.querySelector('#flashMessage')
if (alert) {
    setTimeout(function() {
        alert.remove()
    }, 3000);
}


document.addEventListener('DOMContentLoaded', function() {
    // Récupère le div qui contiendra la collection
    let collectionHolder = document.querySelector('#itinerary_locations');

    if(collectionHolder) {
        // Ajoute un bouton "Ajouter une location"
        let addButton = document.createElement('button');
        addButton.className = 'p-2 bg-blue-500 text-white rounded-md w-full';
        addButton.textContent = 'Ajouter une location';

        // Ajoute le bouton au div parent
        document.querySelector('#itinerary_locations_help').appendChild(addButton);

        // Counter pour générer un index unique pour chaque nouveau champ
        let index = collectionHolder.querySelectorAll('div.location-item').length;

        // Gestion du clic sur le bouton d'ajout
        addButton.addEventListener('click', function(e) {
            e.preventDefault();

            // Récupère le prototype
            let prototype = collectionHolder.dataset.prototype;

            // Remplace '__name__' dans le prototype par l'index actuel
            let newForm = prototype.replace(/__name__/g, index + 1);

            // Incrémente l'index pour la prochaine insertion
            index++;

            // Crée un élément div pour envelopper le nouveau formulaire
            let newFormDiv = document.createElement('div');
            newFormDiv.className = 'location-item mb-3';
            newFormDiv.innerHTML = newForm;

            const formDiv = document.querySelector('.location-item')

            addDeleteLink(formDiv)

            // Ajoute le nouveau formulaire à la collection
            collectionHolder.appendChild(newFormDiv);
        });
    }

    function addDeleteLink(element) {
        if(!element) return
        const  removeButton = document.createElement('button');
        removeButton.textContent =  'Supprimer'
        removeButton.classList.add('block', 'bg-red-500', 'text-white', 'px-4', 'py-2', 'rounded-md')

        removeButton.addEventListener('click', function() {
            element.remove();
        })

        element.appendChild(removeButton)
    }

});
